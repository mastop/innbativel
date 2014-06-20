#//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
#EXTRAIR `ORDERS` DE `PAGAMENTOS`
#//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

SELECT

(p.id + 78059) AS id, 
p.id_usuario AS user_id, 
p.order_id AS braspag_order_id, 
p.antifraud_id AS antifraud_id, 
p.braspag_id AS braspag_id, 
(CASE
	WHEN (p.status = 'iniciado') THEN 'pendente'
    WHEN (p.status = 'aprovado') THEN 'pago'
    WHEN (p.status = 'rejeitado') THEN 'cancelado'
    WHEN (p.status = 'estornado') THEN 'cancelado'
    WHEN (p.status = 'nao_finalizado') THEN 'cancelado'
    WHEN (p.status = 'nao_pago') THEN 'cancelado'
    WHEN (p.status = 'abortado') THEN 'cancelado'
    ELSE p.status
END) AS status,
p.valor_total_com_desconto AS total, 
p.desconto AS credit_discount, 
p.cpf AS cpf, 
p.telefone AS telephone, 
p.presente AS is_gift, 
p.forma_pgto AS payment_terms, 
p.url_boleto AS boleto, 
DATE_FORMAT(p.data_captura, '%Y-%m-%d %H:%i:%s') AS capture_date, 
p.historico AS history, 
DATE_FORMAT(p.data, '%Y-%m-%d %H:%i:%s') AS created_at,
DATE_FORMAT(p.datahora, '%Y-%m-%d %H:%i:%s') AS updated_at

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
DATE_FORMAT(f.data, '%Y-%m-%d %H:%i:%s') AS created_at,
DATE_FORMAT(f.data, '%Y-%m-%d %H:%i:%s') AS updated_at

FROM faturas f

WHERE f.id < 78059

LIMIT 30

INTO OUTFILE "/tmp/orders.csv"
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"' ESCAPED BY '"'
LINES TERMINATED BY "\n";
