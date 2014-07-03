SELECT

pe.id AS id, 
pe.id_periodo AS payment_id, 
(70000 + pe.id_empresa) AS partner_id, 
DATE_FORMAT(pe.pago_em, '%Y-%m-%d %H:%i:%s') AS paid_on, 
pe.total AS total 

FROM pagamentos_empresas AS pe

INTO OUTFILE "/tmp/payments_partners.csv"
CHARACTER SET 'LATIN1'
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '¨' ESCAPED BY ''
LINES TERMINATED BY "\n";
