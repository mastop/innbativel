SELECT 

t.id AS id, 
t.id_pagamento AS order_id, 
t.status AS status, 
p.valor_total_com_desconto AS total, 
p.desconto AS credit_discount, 
p.datahora AS created_at, 
t.datahora AS updated_at 

FROM transacoes t 
LEFT JOIN 
pagamentos p ON p.id = t.id_pagamento 

INTO OUTFILE "/tmp/transactions.csv"
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"' ESCAPED BY '"'
LINES TERMINATED BY "\n";
