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

    INSERT INTO transactions (order_id, changer_id,   status, 	   total, 	  credit_discount, 	   coupon_discount,					         created_at, updated_at)
    	   VALUES			         (NEW.id, 	NEW.user_id,  'pagamento', NEW.total, NEW.credit_discount, COALESCE(@coupon_discount, 0.00), NOW(),		   NOW());
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

    INSERT INTO transactions (order_id, changer_id,   status, 	  total, 	   credit_discount, 	  coupon_discount,					        created_at, updated_at)
    	   VALUES			         (NEW.id, 	NEW.user_id, 'pagamento', NEW.total, NEW.credit_discount, COALESCE(@coupon_discount, 0.00), NOW(),		  NOW());

    UPDATE vouchers SET status = 'pago' WHERE order_id = NEW.id;

  ELSEIF ((NEW.status = 'cancelado' OR NEW.status = 'convercao_creditos') AND OLD.status = 'pago') THEN

    SET @coupon_discount = (SELECT value FROM discount_coupons WHERE id = NEW.coupon_id);

    INSERT INTO transactions (order_id, changer_id,   status,     total,     credit_discount,     coupon_discount,                  created_at, updated_at)
         VALUES              (NEW.id,   NEW.user_id,  NEW.status, NEW.total, NEW.credit_discount, COALESCE(@coupon_discount, 0.00), NOW(),      NOW());

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

    INSERT INTO transactions (order_id, changer_id,   status,      total,     credit_discount,     coupon_discount,                  created_at, updated_at)
         VALUES              (NEW.id,   NEW.user_id,  'cancelado', NEW.total, NEW.credit_discount, COALESCE(@coupon_discount, 0.00), NOW(),      NOW());

  ELSEIF (NEW.status = 'convercao_creditos_parcial' AND OLD.status = 'pago') THEN

    INSERT INTO transactions_vouchers (voucher_id, status,               created_at, updated_at)
         VALUES                       (NEW.id,     'conversao_creditos', NOW(),      NOW());

    INSERT INTO transactions (order_id, changer_id,   status,               total,     credit_discount,     coupon_discount,                  created_at, updated_at)
         VALUES              (NEW.id,   NEW.user_id,  'conversao_creditos', NEW.total, NEW.credit_discount, COALESCE(@coupon_discount, 0.00), NOW(),      NOW());

  END IF;
END;$$

DELIMITER ;
