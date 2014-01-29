<?php
date_default_timezone_set('America/Sao_Paulo');
require 'admin/conexao.php';

header("Content-Type: application/xml; charset=UTF-8");

echo '<?xml version="1.0" encoding="UTF-8"?>
<products xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="http://xml.saveme.com.br/xsd/ofertas.xsd">';

$agora = date('Y-m-d H:i:s');

$sql_oferta = $con->prepare(
"SELECT
    o.titulo_destino,
    e.nome,
    o.id,
    o.quantidade_maxima,
    o.titulo_saveme,
    o.titulo_formatado,
    o.valor_com_desconto,
    o.valor,
    o.percentagem,
    date_format(o.data_fim,'%d/%m/%Y %H:%i:%s') as data_fim,
    ate_format(o.data_inicio,'%d/%m/%Y %H:%i:%s') as data_inicio,
    o.validade_ate_cupom,
    (
    SELECT SUM(quantidade_comprada)
    FROM faturas
    WHERE id_compra = o.id AND tipo_compra = '0' AND (status = '1' OR status_retorno = '1')
    ) as quantidade_vendido
FROM ofertas o
LEFT JOIN empresas e ON e.id = o.id_empresa
WHERE
    o.data_inicio < '$agora' AND
    o.data_fim > '$agora'
ORDER BY o.ordem ASC");

$sql_oferta->execute();

//print_r($sql_oferta->errorInfo());
while($oferta = $sql_oferta->fetch(PDO::FETCH_ASSOC)){
    $sql_imagens = $con->prepare("SELECT imagem FROM ofertas_imagens WHERE id_oferta = '".$oferta['id']."' ORDER BY ordem ASC LIMIT 1");
    $sql_imagens->execute();
    $imagem = $sql_imagens->fetch(PDO::FETCH_ASSOC);

    $recomendar_e_emestoque =
        ($oferta['quantidade_maxima']-$oferta['quantidade_vendida'] > 0)
        ? 1 : 0;

    echo '<product id="'.$oferta['id'].'">
            <name>'.$oferta['titulo_destino'].'</name>
            <producturl><![CDATA[http://'.$_SERVER['SERVER_NAME'].'/oferta/'.$oferta['titulo_formatado'].'-'.$oferta['id'].']]></producturl>
            <smallimage><![CDATA['.substr($imagem['imagem'], 0, -4) . '_t2' . substr($imagem['imagem'], -4).']]></smallimage>
            <price>'.$oferta['valor_com_desconto'].'</price>
            <description>'.$oferta['titulo_saveme'].'</description>
            <instock>'.$recomendar_e_emestoque.'</instock>
            <categoryid1></categoryid1>
            <bigimage><![CDATA['.$imagem['imagem'].']]></bigimage>
            <retailprice>'.$oferta['valor'].'</retailprice>
            <discount>'.$oferta['percentagem'].'</discount>
            <recommendable>'.$recomendar_e_emestoque.'</recommendable>
            <categoryid2></categoryid2>
            <categoryid3></categoryid3>
        </product>';
}

echo '</products>';
?>
