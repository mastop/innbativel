# será preciso criar um modo de obter as imagens, que estão no formato blob. na nova tabela, estou salvando a URL da imagem assim: CONCAT('user_', id, '.jpg') AS img

SELECT
u.id AS id,
u.id AS user_id,
u.facebook_id,
SUBSTRING_INDEX(u.nome, ' ', 1) AS first_name,
SUBSTRING(u.nome,LOCATE(' ', u.nome)) AS last_name,
DATE_FORMAT(u.data_nascimento , '%Y-%m-%d') AS birthday,
u.cpf,
u.telefone AS telephone,
'' AS telephone2,
u.url_img AS img,
u.bonus AS credit,
u.cidade AS city,
(SELECT c.cidade FROM cidades c WHERE c.id = u.id_cidade) AS state,
u.endereco AS street,
u.numero AS number,
u.complemento AS complement,
u.bairro AS neighborhood,
u.cep AS zip,
'' AS company_name,
'' AS cnpj,
'' AS site,
'' AS coordinates

FROM usuarios u

WHERE u.id > 68246 

UNION

SELECT
(70000 + e.id) AS id,
(70000 + e.id) AS user_id,
'' AS facebook_id,
e.nome AS first_name,
'' AS last_name,
'' AS birthday,
'' AS cpf,
e.telefone1 AS telephone,
e.telefone2 AS telephone2,
e.imagem AS img,
0 AS credit,
e.cidade AS city,
e.estado AS state,
e.rua AS street,
e.numero AS number,
e.complemento AS complement,
e.bairro AS neighborhood,
e.cep AS zip,
e.razao_social AS company_name,
e.cnpj AS cnpj,
e.site,
e.coordenadas AS coordinates

FROM empresas e

WHERE e.id > 319

INTO OUTFILE "/tmp/profiles.csv"
CHARACTER SET 'LATIN1'
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '¨' ESCAPED BY ''
LINES TERMINATED BY "\n";
