SELECT

COALESCE(ot.id, (3000 + o.id)) AS id, 
o.id AS offer_id, 
COALESCE(ot.tipo, o.titulo_saveme) AS title, 
COALESCE(ot.valor, o.valor_com_desconto) AS price_with_discount, 
COALESCE(ot.maximo_vendas, o.quantidade_maxima) AS max_qty, 
20 AS max_qty_per_buyer, 
0 AS min_qty, 
DATE_FORMAT(o.validade_de_cupom, '%Y-%m-%d %H:%i:%s') AS voucher_validity_start, 
DATE_FORMAT(o.validade_ate_cupom, '%Y-%m-%d %H:%i:%s') AS voucher_validity_end, 
COALESCE(ot.ordem, 99) AS display_order, 
o.esta_incluso AS included

FROM

ofertas AS o

LEFT JOIN

ofertas_tipos AS ot

ON o.id = ot.id_oferta

INTO OUTFILE "/tmp/offers_options.csv"
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '¨' ESCAPED BY ''
LINES TERMINATED BY "\n";
