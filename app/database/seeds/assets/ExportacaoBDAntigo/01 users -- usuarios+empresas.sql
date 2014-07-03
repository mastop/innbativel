# será preciso criar um modo de obter as imagens, que estão no formato blob. na nova tabela, estou salvando a URL da imagem assim: CONCAT('user_', id, '.jpg') AS img

SELECT
u.id, 
md5(u.id) AS salt, 
u.email AS email, 
u.senha AS password, 
NOW() AS created_at

FROM usuarios u

WHERE u.id > 68246

UNION

SELECT
(70000 + e.id) AS id, 
md5(70000 + e.id) AS salt, 
e.email1 AS email, 
e.senha AS password,
NOW() AS created_at

FROM empresas e

WHERE e.id > 319

ORDER BY id

INTO OUTFILE "/tmp/users.csv"
CHARACTER SET 'LATIN1'
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '¨' ESCAPED BY ''
LINES TERMINATED BY "\n";
