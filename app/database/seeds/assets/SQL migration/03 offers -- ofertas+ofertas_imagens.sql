SELECT

o.id, 
o.id_empresa AS partner_id, 
1 AS ngo_id, 
o.titulo_destino AS title, 
o.titulo_saveme AS subtitle, 
o.titulo_resumido AS description, 
1 AS destiny, 
o.titulo_saveme AS saveme_title, 
o.regulamento AS general_rules, 
DATE_FORMAT(o.data_inicio, '%Y-%m-%d %H:%i:%s') AS starts_on, 
DATE_FORMAT(o.data_fim, '%Y-%m-%d %H:%i:%s') AS ends_on, 
(SELECT o.imagem FROM ofertas_imagens AS oi WHERE oi.id_oferta = o.id LIMIT 1) AS cover_img, 
o.ofertas_anteriores AS offer_old_img, 
o.newsletter_retangular AS newsletter_img, 
o.foto_saveme AS saveme_img, 
o.video, 
CONCAT(o.titulo_formatado, '-', o.id) AS slug, 
o.ordem AS display_order, 
NOW() AS created_at

FROM ofertas AS o

INTO OUTFILE "/tmp/offers.csv"
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"' ESCAPED BY '"'
LINES TERMINATED BY "\n";

#$oferta['titulo_formatado'].'-'.$oferta['id']
