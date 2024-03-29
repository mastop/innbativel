SELECT

co.id AS id, 
co.id_contrato AS contract_id, 
co.opcao AS description, 
co.preco_original AS price_original, 
co.preco_com_desconto AS price_with_discount, 
co.percentagem AS percent_off, 
co.repasse AS transfer, 
co.maximo AS max_qty

FROM contratos_opcoes AS co

WHERE co.id_contrato > 182

INTO OUTFILE "/tmp/contract_options.csv"
CHARACTER SET 'LATIN1'
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '¨' ESCAPED BY ''
LINES TERMINATED BY "\n";
