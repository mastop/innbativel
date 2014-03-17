<?php
date_default_timezone_set('America/Sao_Paulo');
require 'admin/conexao.php';

header("Content-Type: application/xml; charset=UTF-8");

echo '<?xml version="1.0" encoding="UTF-8"?>
<ofertas xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="http://xml.saveme.com.br/xsd/ofertas.xsd">';

$agora = date('Y-m-d H:i:s');

$sql_oferta = $con->prepare(
"SELECT
    o.titulo_destino,
    o.prioridade,
    o.id_cidade,
    o.regulamento,
    o.descricao,
    o.destaque,
    o.foto_saveme AS imagem,
    c.numero as cidade,
    e.nome,
    e.site,
    e.rua,
    e.numero,
    e.complemento,
    e.bairro,
    e.cidade as cidade_empresa,
    e.estado,
    e.cep,
    e.coordenadas,
    o.id,
    o.quantidade_maxima,
    o.titulo_saveme,
    o.titulo_formatado,
    o.valor_com_desconto,
    o.valor,
    o.percentagem,
    o.economizado,
    date_format(o.data_fim,'%d/%m/%Y %H:%i:%s') as data_fim,
    date_format(o.data_inicio,'%d/%m/%Y %H:%i:%s') as data_inicio,
    o.validade_ate_cupom,
    (
    SELECT SUM(quantidade_comprada)
    FROM faturas
    WHERE id_compra = o.id AND tipo_compra = '0' AND (status = '1' OR status_retorno = '1')
    ) as total
FROM ofertas o
LEFT JOIN cidades c ON c.id = o.id_cidade
LEFT JOIN empresas e ON e.id = o.id_empresa
WHERE
    o.data_inicio < '$agora' AND
    o.data_fim > '$agora'
ORDER BY o.data_inicio ASC");
//AND o.oferta_extra = 'n' AND o.oferta_bonus = 'n'
$sql_oferta->execute();
//
//print_r($sql_oferta->errorInfo());
while($oferta = $sql_oferta->fetch(PDO::FETCH_ASSOC)){

    $site = str_replace('http://','',$oferta['site']);
    $cupons_restantes = $oferta['quantidade_maxima']-$oferta['total'];
    $oferta_titulo = strip_tags($oferta['titulo_formatado']);
    $oferta_titulo = strip_tags($oferta['titulo_formatado']);
    $oferta['id_cidade'] = ($oferta['id_cidade'] == '0')?'609':$oferta['cidade'];
    //<regra><![CDATA['.str_replace()$oferta['regulamento'].']]></regra>
    $oferta['regulamento'] = strip_tags($oferta['regulamento'],'<br>,<li>');
    preg_match_all("#<li>(.*?)<\/li>#s", $oferta['regulamento'], $dados);

    echo '<oferta>
        <id>'.$oferta['id'].'</id>
        <titulo><![CDATA['.substr(strip_tags($oferta['titulo_destino'].' | '.$oferta['titulo_saveme']),'0','170').']]></titulo>
        <preco-real>'.$oferta['valor'].'</preco-real>
        <preco-final>'.$oferta['valor_com_desconto'].'</preco-final>
        <desconto>'.$oferta['percentagem'].'</desconto>
        <url-imagem><![CDATA['.( ( substr($oferta['imagem'], 0, 4) == 'http' ) ? $oferta['imagem'] : 'http://'.$_SERVER['SERVER_NAME'].'/admin/fotos/'.$oferta['imagem'] ).']]></url-imagem>
        <link><![CDATA[http://'.$_SERVER['SERVER_NAME'].'/oferta/'.$oferta_titulo.'-'.$oferta['id'].']]></link>
        <data-inicio>'.$oferta['data_inicio'].'</data-inicio>
        <data-fim>'.$oferta['data_fim'].'</data-fim>
        <categoria>6</categoria>
        <detalhes><![CDATA['.str_replace('xxxx','<br>',str_replace('xxxxxxxx','<br>',str_replace('xxxxxxxxxxxx','<br>',str_replace("\r\n",'xxxx',strip_tags($oferta['descricao']))))).']]></detalhes>
        <regras>';
        foreach($dados['1'] as $val){
            echo '<regra><![CDATA['.$val.']]></regra>';
        }
        echo '</regras>
        <destaques>
        <destaque><![CDATA['.$oferta['destaque'].']]></destaque>
        </destaques>
        <cidades>';

        $sql_oferta_cidades = $con->prepare("SELECT oc.prioridade,c.numero FROM ofertas_cidades oc
        LEFT JOIN cidades2 c ON c.id = oc.id_cidade2
        WHERE oc.id_oferta = '".$oferta['id']."'");
        $sql_oferta_cidades->execute();

        while($oferta_cidades = $sql_oferta_cidades->fetch(PDO::FETCH_ASSOC)){
        echo '<cidade>
        <codigo-cidade>'.$oferta_cidades['numero'].'</codigo-cidade>
        <prioridade-cidade>'.$oferta_cidades['prioridade'].'</prioridade-cidade>
        </cidade>';
        }
        echo '</cidades>
        <estabelecimentos>
        <estabelecimento>
        <nome-estabelecimento><![CDATA['.$oferta['nome'].']]></nome-estabelecimento>
        <tipo-estabelecimento>1</tipo-estabelecimento>
        <site-estabelecimento>'.$site.'</site-estabelecimento>
        <pais-estabelecimento>Brasil</pais-estabelecimento>
        <estado-estabelecimento><![CDATA['.$oferta['estado'].']]></estado-estabelecimento>
        <bairro-estabelecimento><![CDATA['.$oferta['bairro'].']]></bairro-estabelecimento>
        <cidade-estabelecimento><![CDATA['.$oferta['cidade_empresa'].']]></cidade-estabelecimento>
        <endereco-estabelecimento><![CDATA['.$oferta['rua'].']]></endereco-estabelecimento>
        <numero-estabelecimento><![CDATA['.$oferta['numero'].']]></numero-estabelecimento>
        <complemento-estabelecimento></complemento-estabelecimento>
        <cep-estabelecimento><![CDATA['.$oferta['cep'].']]></cep-estabelecimento>
        <ddi-estabelecimento></ddi-estabelecimento>
        <ddd-estabelecimento></ddd-estabelecimento>
        <telefone-estabelecimento></telefone-estabelecimento>
        </estabelecimento>
        </estabelecimentos>
        </oferta>
     ';
}

echo '</ofertas>';
?>
