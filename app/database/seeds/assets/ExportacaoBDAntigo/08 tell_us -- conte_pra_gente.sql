SELECT

conte.nome AS name, 
conte.destino AS destiny, 
conte.destino AS partner_name, 
DATE_FORMAT(conte.data, '%Y-%m-%d %H:%i:%s') AS travel_date, 
conte.depoimento AS depoiment, 
conte.foto AS img, 
conte.ordem AS display_order, 
NOW() AS created_at

FROM conte_pra_gente AS conte

INTO OUTFILE "/tmp/tell_us.csv"
CHARACTER SET 'LATIN1'
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '¨' ESCAPED BY ''
LINES TERMINATED BY "\n";
