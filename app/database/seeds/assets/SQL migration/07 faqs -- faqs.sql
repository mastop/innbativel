SELECT

faq.id AS id, 
faq.titulo AS question, 
faq.texto AS answer, 
CONCAT('GRUPO ', faq.posicao+1) AS group_title

FROM faqs AS faq

INTO OUTFILE "/tmp/faqs.csv"
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"' ESCAPED BY '"'
LINES TERMINATED BY "\n";
