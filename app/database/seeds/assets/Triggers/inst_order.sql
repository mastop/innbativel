-- ------------------------
-- NOVO PEDIDO (orders)
-- ------------------------
-- Este trigger insere uma transação (transactions) quando um pedido (orders) é inserido com status é 'pago'
-- ------------------------

-- DROP TRIGGER IF EXISTS inst_order;

-- DELIMITER $$

CREATE TRIGGER inst_order AFTER INSERT ON orders
FOR EACH ROW
BEGIN
  IF (NEW.status = 'pago') THEN
  	SET @coupon_discount = (SELECT value FROM discount_coupons WHERE id = NEW.coupon_id);

    INSERT INTO transactions (order_id, status, 	 total, 	credit_discount, 	                 coupon_discount,				   created_at, updated_at)
    	   VALUES			 (NEW.id, 	'pagamento', NEW.total, COALESCE(NEW.credit_discount, 0.00), COALESCE(@coupon_discount, 0.00), NOW(),	   NOW());
  END IF;
END; -- $$

-- DELIMITER ;
