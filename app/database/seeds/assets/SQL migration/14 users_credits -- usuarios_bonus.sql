SELECT

ub.id AS id, ub.id_destinatario AS user_id, ub.id_remetente AS new_user_id, ub.valor AS value, NOW() AS created_at

FROM usuarios_bonus AS ub

INTO OUTFILE "/tmp/users_credits.csv"
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"' ESCAPED BY '"'
LINES TERMINATED BY "\n";
