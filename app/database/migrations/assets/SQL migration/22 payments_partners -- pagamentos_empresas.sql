SELECT

pe.id AS id, 
pe.id_periodo AS payment_id, 
(7000 + pe.id_empresa) AS partner_id, 
pe.pago_em AS paid_on, 
pe.total AS total 

FROM pagamentos_empresas AS pe

INTO OUTFILE "/tmp/payments_partners.csv"
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"' ESCAPED BY '"'
LINES TERMINATED BY "\n";
