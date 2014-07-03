SELECT

par.titulo AS name, 
par.subtitulo AS destiny, 
par.responsavel AS sponsor, 
par.cargo AS role, 
par.depoimento AS testimony, 
par.foto AS img, 
par.ordem AS display_order

FROM seja_nosso_parceiro AS par

INTO OUTFILE "/tmp/partners_testimonies.csv"
CHARACTER SET 'LATIN1'
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '¨' ESCAPED BY ''
LINES TERMINATED BY "\n";
