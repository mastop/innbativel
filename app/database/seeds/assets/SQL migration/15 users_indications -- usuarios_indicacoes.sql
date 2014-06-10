SELECT

ui.id AS id, ui.id_usuario AS user_id, ui.nome AS name, ui.email AS email, ui.data AS created_at

FROM usuarios_indicacoes AS ui

INTO OUTFILE "/tmp/users_indications.csv"
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"' ESCAPED BY '"'
LINES TERMINATED BY "\n";
