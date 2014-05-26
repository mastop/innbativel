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

-- DROP TRIGGER IF EXISTS upd_transaction;

-- DELIMITER $$

CREATE TRIGGER upd_transaction AFTER UPDATE ON orders
FOR EACH ROW
BEGIN
  IF (NEW.status = 'pago' AND OLD.status != 'pago') THEN

    SET @coupon_discount = (SELECT value FROM discount_coupons WHERE id = NEW.coupon_id);

    INSERT INTO transactions (order_id, status, 	   total, 	  credit_discount, 	                   coupon_discount,					         created_at, updated_at)
    	   VALUES			         (NEW.id, 	'pagamento', NEW.total, COALESCE(NEW.credit_discount, 0.00), COALESCE(@coupon_discount, 0.00), NOW(),		   NOW());

    UPDATE vouchers SET status = 'pago' WHERE order_id = NEW.id;

  ELSEIF (NEW.status = 'cancelado' AND OLD.status = 'pago') THEN

    SET @coupon_discount = (SELECT value FROM discount_coupons WHERE id = NEW.coupon_id);

    INSERT INTO transactions (order_id, status,         total,     credit_discount,                     coupon_discount,                  created_at, updated_at)
         VALUES              (NEW.id,   'cancelamento', NEW.total, COALESCE(NEW.credit_discount, 0.00), COALESCE(@coupon_discount, 0.00), NOW(),      NOW());

    UPDATE vouchers SET status = NEW.status WHERE order_id = NEW.id;

    SET @credit_discount_refund = COALESCE(NEW.credit_discount, 0.00);

    IF(@credit_discount_refund > 0) THEN
      UPDATE profiles SET credit = credit + @credit_discount_refund WHERE id = NEW.user_id;
    END IF;

  ELSEIF (NEW.status = 'convercao_creditos' AND OLD.status = 'pago') THEN

    SET @coupon_discount = (SELECT value FROM discount_coupons WHERE id = NEW.coupon_id);

    INSERT INTO transactions (order_id, status,               total,     credit_discount,                     coupon_discount,                  created_at, updated_at)
         VALUES              (NEW.id,   'convercao_creditos', NEW.total, COALESCE(NEW.credit_discount, 0.00), COALESCE(@coupon_discount, 0.00), NOW(),      NOW());

    UPDATE vouchers SET status = NEW.status WHERE order_id = NEW.id;

    SET @credit_discount_refund = NEW.total + COALESCE(NEW.credit_discount, 0.00);

    IF(@credit_discount_refund > 0) THEN
      UPDATE profiles SET credit = credit + @credit_discount_refund WHERE id = NEW.user_id;
    END IF;

  END IF;
END; -- $$

-- DELIMITER ;