-- ---------------
-- ---------------
-- ---TRIGGERS ---
-- ---------------
-- ---------------

-- ------------------------
-- NOVO PEDIDO (orders)
-- ------------------------
-- Este trigger insere uma transação (transactions) quando um pedido (orders) é inserido com status é 'pago'
-- ------------------------

DROP TRIGGER IF EXISTS inst_transaction;

DELIMITER $$

CREATE TRIGGER inst_transaction AFTER INSERT ON orders
FOR EACH ROW
BEGIN
  IF (NEW.status = 'pago') THEN
  	SET @coupon_discount = (SELECT value FROM discount_coupons WHERE id = NEW.coupon_id);

    INSERT INTO transactions (order_id, status, 	   total, 	  credit_discount, 	   coupon_discount,					         created_at, updated_at)
    	   VALUES			         (NEW.id, 	'pagamento', NEW.total, NEW.credit_discount, COALESCE(@coupon_discount, 0.00), NOW(),		   NOW());
  END IF;
END;$$

DELIMITER ;

-- ------------------------
-- ATUALIZA PEDIDO (orders)
-- ------------------------
-- Este trigger insere uma transação (transactions) quando um pedido (orders) é atualizado. Casos:
--    * transação de aprovação de pagamento: quando o pedido (orders) é atualizado e o novo status é 'pago' e o antigo status era diferente de 'pago'
--    * transação de cancelamento de pagamento: quando o pedido (orders) é atualizado e o novo status é 'cancelado' e o antigo status era 'pago'
--    * transação de cancelamento e conversão do valor do pagamento para créditos na conta do comprador: quando o pedido (orders) é atualizado e o novo status é 'convercao_creditos' e o antigo status era 'pago'
--
-- Observação: os pedidos PARCIALMENTE cancelados (incluindo os parcialmente cancelados e convertidos para créditos na conta do comprador) NÃO são inseridos em transações (transactions) através deste trigger; e sim através do TRIGGER ATUALIZA VOUCHER (vouchers) -- mais abaixo deste documento
-- ------------------------

DROP TRIGGER IF EXISTS upd_transaction;

DELIMITER $$

CREATE TRIGGER upd_transaction AFTER UPDATE ON orders
FOR EACH ROW
BEGIN
  IF (NEW.status = 'pago' AND OLD.status != 'pago') THEN

    SET @coupon_discount = (SELECT value FROM discount_coupons WHERE id = NEW.coupon_id);

    INSERT INTO transactions (order_id, status, 	  total, 	   credit_discount, 	  coupon_discount,					        created_at, updated_at)
    	   VALUES			         (NEW.id, 	'pagamento', NEW.total, NEW.credit_discount, COALESCE(@coupon_discount, 0.00), NOW(),		  NOW());

    UPDATE vouchers SET status = 'pago' WHERE order_id = NEW.id;

  ELSEIF ((NEW.status = 'cancelado' OR NEW.status = 'convercao_creditos') AND OLD.status = 'pago') THEN

    SET @coupon_discount = (SELECT value FROM discount_coupons WHERE id = NEW.coupon_id);

    INSERT INTO transactions (order_id, status,     total,     credit_discount,     coupon_discount,                  created_at, updated_at)
         VALUES              (NEW.id,   NEW.status, NEW.total, NEW.credit_discount, COALESCE(@coupon_discount, 0.00), NOW(),      NOW());

    UPDATE vouchers SET status = NEW.status WHERE order_id = NEW.id;

    IF(NEW.credit_discount > 0) THEN
    	UPDATE profile SET credit = credit + NEW.credit_discount WHERE id = NEW.user_id;
    ENDIF;

  END IF;
END;$$

DELIMITER ;

-- ------------------------
-- NOVO VOUCHER (vouchers)
-- ------------------------
-- Este trigger insere uma transação de voucher (transactions_vouchers) quando um voucher (vouchers) é inserido com status é 'pago'
-- ------------------------

DROP TRIGGER IF EXISTS inst_voucher;

DELIMITER $$

CREATE TRIGGER inst_voucher AFTER INSERT ON vouchers
FOR EACH ROW
BEGIN
  IF (NEW.status = 'pago') THEN
  	INSERT INTO transactions_vouchers (voucher_id, status, created_at, 	updated_at)
    	   VALUES			 		              (NEW.id,	   'pago', NOW(),		    NOW());
  END IF;
END;$$

DELIMITER ;

-- ------------------------
-- ATUALIZA VOUCHER (vouchers)
-- ------------------------
-- Este trigger insere uma transação de voucher (transactions_vouchers) quando um voucher (vouchers) é atualizado. Casos:
--    * transação de aprovação de voucher: quando o voucher (vouchers) é atualizado e o novo status é 'pago' e o antigo status era diferente de 'pago'
--    * transação de cancelamento de voucher: quando o voucher (vouchers) é atualizado e o novo status é 'cancelado' e o antigo status era 'pago'
--    * transação de cancelamento e conversão do valor do voucher para créditos na conta do comprador: quando o voucher (vouchers) é atualizado e o novo status é 'convercao_creditos' e o antigo status era 'pago'
-- 
-- Observação: um voucher cancelado (incluindo os parcialmente cancelados e convertidos para créditos na conta do comprador) pode representar um cancelamento parcial de um pedido. Nestes casos, o novo status será 'cancelado_parcial' ou 'convercao_creditos_parcial'
-- ------------------------

DROP TRIGGER IF EXISTS upd_vouchers;

DELIMITER $$

CREATE TRIGGER upd_vouchers AFTER UPDATE ON vouchers
FOR EACH ROW
BEGIN
  IF (NEW.status = 'pago' AND OLD.status != 'pago') THEN

  	INSERT INTO transactions_vouchers (voucher_id, status, created_at, 	updated_at)
    	   VALUES			 		              (NEW.id,	   'pago', NOW(),		    NOW());

  ELSEIF ((NEW.status = 'cancelado' OR NEW.status = 'convercao_creditos') AND OLD.status = 'pago') THEN

    INSERT INTO transactions_vouchers (voucher_id, status,     created_at, updated_at)
         VALUES                       (NEW.id,     NEW.status, NOW(),      NOW());

  ELSEIF (NEW.status = 'cancelado_parcial' AND OLD.status = 'pago') THEN

    INSERT INTO transactions_vouchers (voucher_id, status,      created_at, updated_at)
         VALUES                       (NEW.id,     'cancelado', NOW(),      NOW());

    SET @original_order = (SELECT SUM(oo.price_with_discount) FROM vouchers v LEFT JOIN offers_options oo ON v.offer_option_id = oo.id WHERE v.order_id = NEW.order_id);
    SET @cancellations = (SELECT COALESCE(SUM(oo.price_with_discount), 0.00) FROM vouchers v LEFT JOIN offers_options oo ON v.offer_option_id = oo.id WHERE v.order_id = NEW.order_id AND v.status IN ('cancelado', 'cancelado_parcial', 'convercao_creditos', 'convercao_creditos_parcial'));
    SET @residual_order = @original_order - @cancellations;

    SET @residual_credit_discount = (SELECT (o.credit_discount - (SELECT COALESCE(SUM(t.credit_discount), 0.00) FROM transactions t WHERE t.order_id = NEW.order_id AND t.status IN ('cancelado', 'cancelado_parcial', 'convercao_creditos', 'convercao_creditos_parcial'))) FROM orders o WHERE o.id = NEW.order_id);
    SET @residual_coupon_discount = (SELECT (dc.value - (SELECT COALESCE(SUM(t.coupon_discount), 0.00) FROM transactions t WHERE t.order_id = NEW.order_id AND t.status IN ('cancelado', 'cancelado_parcial', 'convercao_creditos', 'convercao_creditos_parcial'))) FROM orders o LEFT JOIN discount_coupons dc ON o.coupon_id = dc.id WHERE o.id = NEW.order_id);

    SET @original_payment = (SELECT o.total FROM orders o WHERE o.id = NEW.order_id);
    SET @previous_cancellation_payment = (SELECT COALESCE(SUM(t.total), 0.00) FROM transactions t WHERE t.order_id = NEW.order_id AND t.status IN ('cancelado', 'cancelado_parcial', 'convercao_creditos', 'convercao_creditos_parcial'));
    SET @balance = @original_payment - @previous_cancellation_payment;

    IF (@residual_order <= @residual_coupon_discount) THEN
      
      SET @coupon_discount_refund = @residual_coupon_discount - @residual_order;
      SET @credit_discount_refund = @residual_credit_discount;
      SET @money_refund = @balance;

      INSERT INTO transactions (order_id,       status,              total,         credit_discount,         coupon_discount,         created_at, updated_at)
           VALUES              (NEW.order_id,   'cancelado_parcial', @money_refund, @credit_discount_refund, @coupon_discount_refund, NOW(),      NOW());

      UPDATE profiles p
      LEFT JOIN orders o ON p.user_id = o.user_id
      SET p.credit = p.credit + @credit_discount_refund
      WHERE o.id = NEW.order_id;

    ELSEIF (@residual_order <= @residual_coupon_discount + @residual_credit_discount) THEN

      SET @credit_discount_refund = @residual_credit_discount - (@residual_order - @residual_coupon_discount);
      SET @money_refund = @balance;

      INSERT INTO transactions (order_id,       status,              total,         credit_discount,         created_at, updated_at)
           VALUES              (NEW.order_id,   'cancelado_parcial', @money_refund, @credit_discount_refund, NOW(),      NOW());

      UPDATE profiles p
      LEFT JOIN orders o ON p.user_id = o.user_id
      SET p.credit = p.credit + @credit_discount_refund
      WHERE o.id = NEW.order_id;

    ELSE

      SET @new_residual_order = @residual_order - (@residual_coupon_discount + @residual_credit_discount);
      SET @interest_rate = (SELECT o.interest_rate FROM orders o WHERE o.id = NEW.order_id);
      SET @new_balance = @new_residual_order + (@new_residual_order * @interest_rate);

      SET @money_refund = @balance - @new_balance;

      INSERT INTO transactions (order_id,       status,              total,         created_at, updated_at)
           VALUES              (NEW.order_id,   'cancelado_parcial', @money_refund, NOW(),      NOW());

    END IF;

  ELSEIF (NEW.status = 'convercao_creditos_parcial' AND OLD.status = 'pago') THEN

    INSERT INTO transactions_vouchers (voucher_id, status,               created_at, updated_at)
         VALUES                       (NEW.id,     'conversao_creditos', NOW(),      NOW());

  END IF;
END;$$

DELIMITER ;
