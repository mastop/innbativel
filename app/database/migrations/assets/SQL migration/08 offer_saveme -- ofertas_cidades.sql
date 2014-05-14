SELECT

oc.id_oferta AS offer_id, oc.id_cidade2 AS saveme_id, oc.prioridade AS priority

FROM ofertas_cidades AS oc

INTO OUTFILE "/tmp/offer_saveme.csv"
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"' ESCAPED BY '"'
LINES TERMINATED BY "\n";
