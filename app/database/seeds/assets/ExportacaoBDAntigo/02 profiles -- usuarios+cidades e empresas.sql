# será preciso criar um modo de obter as imagens, que estão no formato blob. na nova tabela, estou salvando a URL da imagem assim: CONCAT('user_', id, '.jpg') AS img

SELECT
id AS id,
id AS user_id,
facebook_id,
SUBSTRING_INDEX(nome, ' ', 1) AS first_name,
SUBSTRING(nome,LOCATE(' ', nome)) AS last_name,
DATE_FORMAT(data_nascimento , '%Y-%m-%d') AS birthday,
cpf,
telefone AS telephone,
'' AS telephone2,
url_img AS img,
bonus AS credit,
cidade AS city,
(SELECT cidade FROM cidades WHERE id = id_cidade) AS state,
endereco AS street,
numero AS number,
complemento AS complement,
bairro AS neighborhood,
cep AS zip,
'' AS company_name,
'' AS cnpj,
'' AS site,
'' AS coordinates

FROM usuarios

UNION

SELECT
(70000 + id) AS id,
(70000 + id) AS user_id,
'' AS facebook_id,
nome AS first_name,
'' AS last_name,
'' AS birthday,
'' AS cpf,
telefone1 AS telephone,
telefone2 AS telephone2,
imagem AS img,
0 AS credit,
cidade AS city,
estado AS state,
rua AS street,
numero AS number,
complemento AS complement,
bairro AS neighborhood,
cep AS zip,
razao_social AS company_name,
cnpj AS cnpj,
site,
coordenadas AS coordinates

FROM empresas

INTO OUTFILE "/tmp/profiles.csv"
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '¨' ESCAPED BY ''
LINES TERMINATED BY "\n";
