SELECT

c.id AS id, c.cidade AS title, c.numero AS geocode

FROM cidades2 AS c

INTO OUTFILE "/tmp/saveme.csv"
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"' ESCAPED BY '"'
LINES TERMINATED BY "\n";
