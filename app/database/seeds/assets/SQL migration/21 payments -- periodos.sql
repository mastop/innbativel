SELECT

per.id AS id, 
per.inicio AS sales_from, 
per.fim AS sales_to, 
per.data_pagamento AS date

FROM periodos AS per

INTO OUTFILE "/tmp/payments.csv"
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"' ESCAPED BY '"'
LINES TERMINATED BY "\n";
