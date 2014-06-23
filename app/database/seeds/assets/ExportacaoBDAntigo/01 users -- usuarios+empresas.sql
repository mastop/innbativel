# será preciso criar um modo de obter as imagens, que estão no formato blob. na nova tabela, estou salvando a URL da imagem assim: CONCAT('user_', id, '.jpg') AS img

SELECT
id, 
md5(id) AS salt, 
email AS email, 
senha AS password, 
NOW() AS created_at

FROM usuarios

UNION

SELECT
(70000 + id) AS id, 
md5(70000 + id) AS salt, 
email1 AS email, 
senha AS password,
NOW() AS created_at

FROM empresas

INTO OUTFILE "/tmp/users.csv"
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '¨' ESCAPED BY ''
LINES TERMINATED BY "\n";
