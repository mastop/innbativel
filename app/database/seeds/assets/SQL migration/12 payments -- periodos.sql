SELECT

per.id AS id, 
DATE_FORMAT(per.inicio, '%Y-%m-%d %H:%i:%s') AS sales_from, 
DATE_FORMAT(per.fim, '%Y-%m-%d %H:%i:%s') AS sales_to, 
DATE_FORMAT(per.data_pagamento, '%Y-%m-%d') AS date

FROM periodos AS per

INTO OUTFILE "/tmp/payments.csv"
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"' ESCAPED BY '"'
LINES TERMINATED BY "\n";
