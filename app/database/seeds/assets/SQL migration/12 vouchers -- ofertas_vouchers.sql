SELECT

ov.id AS id, 
ov.id_compra AS order_offer_id, 
ov.usado AS used, 
ov.numero AS display_code, 
ov.nome AS name, 
ov.email_voucher AS email

FROM ofertas_vouchers AS ov

INTO OUTFILE "/tmp/vouchers.csv"
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"' ESCAPED BY '"'
LINES TERMINATED BY "\n";
