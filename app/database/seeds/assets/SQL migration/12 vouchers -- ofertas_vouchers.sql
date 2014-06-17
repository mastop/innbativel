(SELECT

ov.id AS id, 
(ov.id_pagamento + 78059) AS order_id,
COALESCE(ov.id_tipo_apto, (ov.id + 2000)) AS offer_option_id
ov.usado AS used, 
ov.numero AS display_code, 
ov.nome AS name, 
ov.email_voucher AS email,
p.status AS status

FROM ofertas_vouchers AS ov

LEFT JOIN pagamentos p ON p.id = ov.id_pagamento

WHERE ov.id_pagamento IS NOT NULL)

UNION ALL

(SELECT

ov.id AS id, 
ov.id_compra AS order_id,
COALESCE(ov.id_tipo_apto, (ov.id + 2000)) AS offer_option_id
ov.usado AS used, 
ov.numero AS display_code, 
ov.nome AS name, 
ov.email_voucher AS email,
(CASE
    WHEN (f.status = 0 OR f.status = '0') THEN 'pendente'
    WHEN (f.status = 1 OR f.status = '1') THEN 'aprovado'
    ELSE 'cancelado'
END) AS status,

FROM ofertas_vouchers AS ov

LEFT JOIN faturas f ON f.id = ov.id_compra

WHERE ov.id < 114435)

INTO OUTFILE "/tmp/vouchers.csv"
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"' ESCAPED BY '"'
LINES TERMINATED BY "\n";
