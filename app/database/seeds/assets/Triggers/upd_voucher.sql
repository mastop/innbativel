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

-- DROP TRIGGER IF EXISTS upd_vouchers;

-- DELIMITER $$

CREATE TRIGGER upd_vouchers AFTER UPDATE ON vouchers
FOR EACH ROW
BEGIN
  IF (NEW.status = 'pago' AND OLD.status != 'pago') THEN

    SET @transaction_id = (SELECT t.id FROM transactions t WHERE t.order_id = NEW.order_id ORDER BY t.id DESC LIMIT 1);

    INSERT INTO transactions_vouchers (voucher_id, transaction_id,  status,		   created_at, updated_at)
         VALUES                       (NEW.id,     @transaction_id, 'pagamento', NOW(),      NOW());

  ELSEIF ((NEW.status = 'cancelado' OR NEW.status = 'convercao_creditos') AND OLD.status = 'pago') THEN

    SET @transaction_id = (SELECT t.id FROM transactions t WHERE t.order_id = NEW.order_id ORDER BY t.id DESC LIMIT 1);

    INSERT INTO transactions_vouchers (voucher_id, transaction_id,  status,         created_at, updated_at)
         VALUES                       (NEW.id,     @transaction_id, 'cancelamento', NOW(),      NOW());

  ELSEIF ((NEW.status = 'cancelado_parcial' OR NEW.status = 'convercao_creditos_parcial') AND OLD.status = 'pago') THEN

    IF(NEW.status = 'cancelado_parcial') THEN
      SET @transaction_id = (SELECT inst_transaction_partial_cancellation(NEW.order_id, NEW.offer_option_id, 'cancelamento_parcial'));
    ELSE
      SET @transaction_id = (SELECT inst_transaction_partial_cancellation(NEW.order_id, NEW.offer_option_id, 'convercao_creditos_parcial'));
    END IF;

    INSERT INTO transactions_vouchers (voucher_id, transaction_id,  status,         created_at, updated_at)
         VALUES                       (NEW.id,     @transaction_id, 'cancelamento', NOW(),      NOW());

  END IF;
END; -- $$

-- DELIMITER ;
