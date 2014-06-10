SELECT

f.id AS id, f.id AS order_id, (SELECT id_tipo_apto FROM ofertas_vouchers ov WHERE ov.id_compra = f.id LIMIT 1) AS offer_option_id, f.quantidade_comprada AS qty

FROM faturas f

LIMIT 30

INTO OUTFILE "/tmp/orders_offers_options.csv"
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"' ESCAPED BY '"'
LINES TERMINATED BY "\n";
