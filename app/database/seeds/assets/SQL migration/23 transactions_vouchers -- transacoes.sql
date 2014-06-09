SELECT 

ov.id AS id, 
ov.id AS voucher_id, 
t.id_pagamento_empresa AS payment_partner_id, 
t.id AS transaction_id, 
t.status AS status, 
t.datahora AS created_at, 
t.datahora AS updated_at 

FROM transacoes t 
LEFT JOIN 
ofertas_vouchers ov ON t.id_pagamento = ov.id_pagamento

INTO OUTFILE "/tmp/transactions_vouchers.csv"
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"' ESCAPED BY '"'
LINES TERMINATED BY "\n";
