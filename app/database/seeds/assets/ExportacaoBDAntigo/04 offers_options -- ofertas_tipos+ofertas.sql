SELECT

COALESCE(ot.id, (3000 + o.id)) AS id, 
o.id AS offer_id, 
COALESCE(ot.tipo, COALESCE(o.titulo_saveme,o.titulo)) AS title, 
COALESCE(ot.valor, o.valor_com_desconto) AS price_with_discount, 
COALESCE(ot.valor_repasse, o.valor_repasse) AS transfer, 
COALESCE(ot.maximo_vendas, o.quantidade_maxima) AS max_qty, 
0 AS min_qty, 
DATE_FORMAT(o.validade_de_cupom, '%Y-%m-%d %H:%i:%s') AS voucher_validity_start, 
DATE_FORMAT(o.validade_ate_cupom, '%Y-%m-%d %H:%i:%s') AS voucher_validity_end, 
COALESCE(ot.ordem, 99) AS display_order

FROM

ofertas AS o

LEFT JOIN

ofertas_tipos AS ot

ON o.id = ot.id_oferta

WHERE o.id > 1092 AND ot.id_oferta >1092 

INTO OUTFILE "/tmp/offers_options.csv"
CHARACTER SET 'LATIN1'
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '¨' ESCAPED BY ''
LINES TERMINATED BY "\n";
