-- ------------------------
-- NOVO VOUCHER (vouchers)
-- ------------------------
-- Este trigger insere uma transação de voucher (transactions_vouchers) quando um voucher (vouchers) é inserido com status é 'pago'
-- ------------------------

-- DROP TRIGGER IF EXISTS inst_voucher;

-- DELIMITER $$

CREATE TRIGGER inst_voucher AFTER INSERT ON vouchers
FOR EACH ROW
BEGIN
  IF (NEW.status = 'pago') THEN
    INSERT INTO transactions_vouchers (voucher_id, status, 		created_at,  updated_at)
         VALUES                       (NEW.id,     'pagamento', NOW(),       NOW());
  END IF;
END; -- $$

-- DELIMITER ;
