#//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
#EXTRAIR `ORDERS` DE `PAGAMENTOS`
#//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

SELECT

(p.id + 78059) AS id, 
p.id_usuario AS user_id, 
p.order_id AS braspag_order_id, 
p.antifraud_id AS antifraud_id, 
p.braspag_id AS braspag_id, 
p.status AS status,
p.valor_total_com_desconto AS total, 
p.desconto AS credit_discount, 
p.cpf AS cpf, 
p.telefone AS telephone, 
p.presente AS is_gift, 
p.forma_pgto AS payment_terms, 
p.url_boleto AS boleto, 
p.data_captura AS capture_date, 
p.historico AS history, 
p.data AS created_at,
p.datahora AS updated_at

FROM pagamentos p 

LIMIT 30

#///////////
UNION ALL
#///////////


#//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
#EXTRAIR `ORDERS` DE `FATURAS` (ANTIGA TABELA DE PAGAMENTOS)
#//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

SELECT

f.id AS id, 
f.id_usuario AS user_id, 
'' AS braspag_order_id, 
'' AS antifraud_id, 
'' AS braspag_id,
(CASE
        WHEN (f.status = 0 OR f.status = '0') THEN 'pendente'
        WHEN (f.status = 1 OR f.status = '1') THEN 'aprovado'
        ELSE 'cancelado'
END) AS status,
f.valor_total_com_desconto AS total, 
f.desconto AS credit_discount, 
'' AS cpf, 
'' AS telephone, 
f.presente AS is_gift, 
'' AS payment_terms, 
'' AS boleto, 
'' AS capture_date, 
'' AS history, 
f.data AS created_at,
f.data AS updated_at

FROM faturas f

WHERE faturas.id < 78059

LIMIT 30

INTO OUTFILE "/tmp/orders.csv"
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"' ESCAPED BY '"'
LINES TERMINATED BY "\n";
