SELECT

id_oferta AS offer_id, id_usuario AS user_id, comentario AS comment, aprovado AS approved, ordem AS display_order, datahora AS created_at

FROM comentarios

INTO OUTFILE "/tmp/comments.csv"
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"' ESCAPED BY '"'
LINES TERMINATED BY "\n";
