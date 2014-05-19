SELECT

(SELECT o.id FROM ofertas AS o WHERE o.titulo_destino = opr.destino ORDER BY o.id LIMIT 1) AS offer_id, NULL as user_id, opr.email AS email, NULL as name, NULL as telephone, NOW() AS created_at

FROM ofertas_pre_reservas AS opr GROUP BY email, offer_id ORDER BY offer_id

INTO OUTFILE "/tmp/pre_bookings.csv"
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"' ESCAPED BY '"'
LINES TERMINATED BY "\n";
