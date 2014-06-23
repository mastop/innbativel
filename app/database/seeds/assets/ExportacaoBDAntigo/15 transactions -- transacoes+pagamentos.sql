SELECT 

t.id AS id, 
(t.id_pagamento + 78059) AS order_id, 
t.status AS status, 
p.valor_total_com_desconto AS total, 
p.desconto AS credit_discount, 
DATE_FORMAT(p.datahora, '%Y-%m-%d %H:%i:%s') AS created_at, 
DATE_FORMAT(t.datahora, '%Y-%m-%d %H:%i:%s') AS updated_at 

FROM transacoes t 

LEFT JOIN 

pagamentos p ON p.id = t.id_pagamento 

INTO OUTFILE "/tmp/transactions.csv"
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '¨' ESCAPED BY ''
LINES TERMINATED BY "\n";
