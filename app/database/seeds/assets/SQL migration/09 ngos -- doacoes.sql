SELECT

ong.id AS id, ong.nome AS name

FROM doacoes AS ong

INTO OUTFILE "/tmp/ngos.csv"
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"' ESCAPED BY '"'
LINES TERMINATED BY "\n";
