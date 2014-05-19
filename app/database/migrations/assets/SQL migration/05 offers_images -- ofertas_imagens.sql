SELECT

oi.id_oferta AS offer_id, oi.imagem AS url

FROM ofertas_imagens AS oi

INTO OUTFILE "/tmp/offers_images.csv"
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"' ESCAPED BY '"'
LINES TERMINATED BY "\n";
