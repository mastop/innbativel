SELECT 

ov.id AS voucher_id, 
t.id_pagamento_empresa AS payment_partner_id, 
t.id AS transaction_id, 
(CASE
    WHEN (t.status = 'aprovado') THEN 'pagamento'
    ELSE 'cancelamento'
END) AS status,
DATE_FORMAT(t.datahora, '%Y-%m-%d %H:%i:%s') AS created_at, 
DATE_FORMAT(t.datahora, '%Y-%m-%d %H:%i:%s') AS updated_at 

FROM transacoes t 

LEFT JOIN 
ofertas_vouchers ov ON t.id_pagamento = ov.id_pagamento

WHERE ov.id >= 114435

INTO OUTFILE "/tmp/transactions_vouchers.csv"
CHARACTER SET 'LATIN1'
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '¨' ESCAPED BY ''
LINES TERMINATED BY "\n";
