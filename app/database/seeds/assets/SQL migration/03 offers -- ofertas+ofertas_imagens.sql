SELECT

id, id_empresa AS partner_id, 1 AS ngo_id, titulo_destino AS title, titulo_saveme AS subtitle, titulo_resumido AS description, 1 AS destiny, titulo_saveme AS saveme_title, regulamento AS general_rules, data_inicio AS starts_on, data_fim AS ends_on, (SELECT imagem FROM ofertas_imagens AS oi WHERE oi.id_oferta = o.id LIMIT 1) AS cover_img, ofertas_anteriores AS offer_old_img, newsletter_retangular AS newsletter_img, foto_saveme AS saveme_img, video, CONCAT(titulo_formatado, '-', id) AS slug, ordem AS display_order, NOW() AS created_at

FROM ofertas AS o

INTO OUTFILE "/tmp/offers.csv"
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"' ESCAPED BY '"'
LINES TERMINATED BY "\n";

#$oferta['titulo_formatado'].'-'.$oferta['id']
