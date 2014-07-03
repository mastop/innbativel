SELECT

o.id, 
(70000 + o.id_empresa) AS partner_id, 
5 AS ngo_id, 
1 AS category_id, 
COALESCE(o.titulo_resumido, o.titulo_destino) AS title, 
o.titulo_saveme AS subtitle, 
o.destaque AS features,
1 AS destiny_id, 
o.regulamento AS rules, 
DATE_FORMAT(o.data_inicio, '%Y-%m-%d %H:%i:%s') AS starts_on, 
DATE_FORMAT(o.data_fim, '%Y-%m-%d %H:%i:%s') AS ends_on, 
CONCAT(o.titulo_formatado, '-', o.id) AS slug, 
o.ordem AS display_order, 
NOW() AS created_at,
NOW() AS deleted_at

FROM ofertas AS o

WHERE o.id > 1092

INTO OUTFILE "/tmp/offers.csv"
CHARACTER SET 'LATIN1'
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '¨' ESCAPED BY ''
LINES TERMINATED BY "\n";
