# será preciso criar um modo de obter as imagens, que estão no formato blob. na nova tabela, estou salvando a URL da imagem assim: CONCAT('user_', id, '.jpg') AS img

SELECT
u.id, 
md5(u.id) AS salt, 
u.email AS email, 
u.senha AS password, 
NOW() AS created_at

FROM usuarios u

WHERE (u.email LIKE '%@%' OR u.id IN (42981,40525,38265,37245,35422,32303,26957,12499,11635,7603,6768,6728,6420,6355,5990,4610,3562)) 

UNION

SELECT
(70000 + e.id) AS id, 
md5(70000 + e.id) AS salt, 
e.email1 AS email, 
e.senha AS password,
NOW() AS created_at

FROM empresas e

ORDER BY id

INTO OUTFILE "/tmp/users.csv"
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '¨' ESCAPED BY ''
LINES TERMINATED BY "\n";
