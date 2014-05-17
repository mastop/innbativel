SELECT 

ov.id AS id, 
ov.id AS voucher_id, 
t.id_pagamento_empresa AS payment_partner_id, 
t.status AS status, 
t.datahora AS created_at, 
t.datahora AS updated_at 

FROM transacoes t 
LEFT JOIN 
pagamentos p ON t.id_pagamento = p.id 
LEFT JOIN 
faturas f ON p.braspag_id = f.braspag_id 
LEFT JOIN ofertas_vouchers ov ON ov.id_compra = f.id

INTO OUTFILE "/tmp/transactions_vouchers.csv"
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"' ESCAPED BY '"'
LINES TERMINATED BY "\n";
