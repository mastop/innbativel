-- ------------------------
-- INSERE TRANSAÇÃO (transaction) EM CASO DE CANCELAMENTO PARCIAL
-- ------------------------
-- Esta função insere uma transação (transactions) quando há o cancelamento parcial de uma compra, 
-- ou seja, quando apenas um voucher (vouchers) é cancelado em uma compra de mais de um voucher
-- ------------------------

-- DROP PROCEDURE IF EXISTS inst_transaction_partial_cancellation;

-- DELIMITER $$
   
CREATE PROCEDURE inst_transaction_partial_cancellation (arg_order_id INT, arg_offer_option_id INT, arg_status VARCHAR(30)) 
BEGIN
   -- INICIO CASO CUPOM DE DESCONTO RESTRITO A OFERTA
    -- EXPLICAÇÃO: CASOS QUANDO O CANCELAMENTO PARCIAL É DE UMA OFERTA QUE GANHOU DESCONTO POR UM CUPOM DE DESCONTO RESTRITA APENAS A ELA
    SET @coupon_discount_offer_id = (SELECT COALESCE(dc.offer_id, 0) FROM orders o LEFT JOIN discount_coupons dc ON o.coupon_id = dc.id WHERE o.id = arg_order_id);
    SET @offer_id = (SELECT oo.offer_id FROM offers_options oo WHERE oo.id = arg_offer_option_id);

    IF(@offer_id = @coupon_discount_offer_id) THEN

      SET @remaining_coupon_discount_temp = (SELECT (dc.value - (SELECT COALESCE(SUM(t.coupon_discount), 0.00) FROM transactions t WHERE t.order_id = arg_order_id AND t.status IN ('cancelado', 'cancelado_parcial', 'convercao_creditos', 'convercao_creditos_parcial'))) FROM orders o LEFT JOIN discount_coupons dc ON o.coupon_id = dc.id WHERE o.id = arg_order_id);

      IF (@remaining_coupon_discount_temp > 0) THEN

        SET @count = (SELECT COUNT(v.id) FROM orders o LEFT JOIN vouchers v ON o.id = v.order_id LEFT JOIN offers_options oo ON v.offer_option_id = oo.id WHERE o.id = arg_order_id AND v.status = 'pago' AND oo.offer_id = @coupon_discount_offer_id);

        IF(@count = 0) THEN

          INSERT INTO transactions (order_id,       status,              coupon_discount,                 created_at, updated_at)
               VALUES              (arg_order_id,   arg_status,          @remaining_coupon_discount_temp, NOW(),      NOW());

        END IF;

      END IF;

    END IF;
    -- FIM CASO CUPOM DE DESCONTO RESTRITO A OFERTA

    SET @original_order = (SELECT SUM(oo.price_with_discount) FROM vouchers v LEFT JOIN offers_options oo ON v.offer_option_id = oo.id WHERE v.order_id = arg_order_id);
    SET @cancellations = (SELECT COALESCE(SUM(oo.price_with_discount), 0.00) FROM vouchers v LEFT JOIN offers_options oo ON v.offer_option_id = oo.id WHERE v.order_id = arg_order_id AND v.status IN ('cancelado', 'cancelado_parcial', 'convercao_creditos', 'convercao_creditos_parcial'));
    SET @remaining_order = @original_order - @cancellations;

    SET @remaining_credit_discount = (SELECT (o.credit_discount - (SELECT COALESCE(SUM(t.credit_discount), 0.00) FROM transactions t WHERE t.order_id = arg_order_id AND t.status IN ('cancelado', 'cancelado_parcial', 'convercao_creditos', 'convercao_creditos_parcial'))) FROM orders o WHERE o.id = arg_order_id);
    SET @remaining_coupon_discount = (SELECT (dc.value - (SELECT COALESCE(SUM(t.coupon_discount), 0.00) FROM transactions t WHERE t.order_id = arg_order_id AND t.status IN ('cancelado', 'cancelado_parcial', 'convercao_creditos', 'convercao_creditos_parcial'))) FROM orders o LEFT JOIN discount_coupons dc ON o.coupon_id = dc.id WHERE o.id = arg_order_id);

    SET @original_payment = (SELECT o.total FROM orders o WHERE o.id = arg_order_id);
    SET @previous_cancellation_payment = (SELECT COALESCE(SUM(t.total), 0.00) FROM transactions t WHERE t.order_id = arg_order_id AND t.status IN ('cancelado', 'cancelado_parcial', 'convercao_creditos', 'convercao_creditos_parcial'));
    SET @balance = @original_payment - @previous_cancellation_payment;

    -- INICIO CASO DOAÇÃO
    -- MACETE PARA SUPORTAR CANCELAMENTOS PARCIAIS QUANDO A COMPRA INCLUI UMA DOAÇÃO
    SET @donation = (SELECT o.donation FROM orders o WHERE o.id = arg_order_id);
    SET @remaining_order = @remaining_order + @donation;
    SET @remaining_coupons = (SELECT COUNT(v.id) FROM vouchers v WHERE v.status = 'pago' AND v.order_id = arg_order_id);
    IF(@remaining_coupons = 0) THEN SET @remaining_coupon_discount = @remaining_coupon_discount + @donation; END IF;
    -- FIM CASO DOAÇÃO

    IF (@remaining_order <= @remaining_coupon_discount) THEN
      
      SET @coupon_discount_refund = @remaining_coupon_discount - @remaining_order;
      SET @credit_discount_refund = @remaining_credit_discount;
      SET @money_refund = @balance;

      INSERT INTO transactions (order_id,       status,     total,                         credit_discount,                         coupon_discount,                         created_at, updated_at)
           VALUES              (arg_order_id,   arg_status, COALESCE(@money_refund, 0.00), COALESCE(@credit_discount_refund, 0.00), COALESCE(@coupon_discount_refund, 0.00), NOW(),      NOW());

      IF(arg_status = 'convercao_creditos_parcial') THEN SET @credit_discount_refund = @credit_discount_refund + @money_refund; END IF;

      UPDATE profiles p
      LEFT JOIN orders o ON p.user_id = o.user_id
      SET p.credit = p.credit + @credit_discount_refund
      WHERE o.id = arg_order_id;

    ELSEIF (@remaining_order <= @remaining_coupon_discount + @remaining_credit_discount) THEN

      SET @credit_discount_refund = @remaining_credit_discount - (@remaining_order - @remaining_coupon_discount);
      SET @money_refund = @balance;

      INSERT INTO transactions (order_id,       status,     total,                         credit_discount,                         created_at, updated_at)
           VALUES              (arg_order_id,   arg_status, COALESCE(@money_refund, 0.00), COALESCE(@credit_discount_refund, 0.00), NOW(),      NOW());

      IF(arg_status = 'convercao_creditos_parcial') THEN SET @credit_discount_refund = @credit_discount_refund + @money_refund; END IF;

      UPDATE profiles p
      LEFT JOIN orders o ON p.user_id = o.user_id
      SET p.credit = p.credit + @credit_discount_refund
      WHERE o.id = arg_order_id;

    ELSE

      SET @new_remaining_order = @remaining_order - (@remaining_coupon_discount + @remaining_credit_discount);
      SET @interest_rate = (SELECT o.interest_rate FROM orders o WHERE o.id = arg_order_id);
      SET @new_balance = @new_remaining_order + (@new_remaining_order * @interest_rate);

      SET @money_refund = @balance - @new_balance;

      INSERT INTO transactions (order_id,       status,     total,                         created_at, updated_at)
           VALUES              (arg_order_id,   arg_status, COALESCE(@money_refund, 0.00), NOW(),      NOW());

      IF(arg_status = 'convercao_creditos_parcial') THEN

        UPDATE profiles p
        LEFT JOIN orders o ON p.user_id = o.user_id
        SET p.credit = p.credit + @money_refund
        WHERE o.id = arg_order_id;

      END IF;

    END IF;
END; -- $$

-- DELIMITER ;
