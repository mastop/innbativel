SELECT

con.id AS id, 
(70000 + con.id_empresa) AS partner_id, 
con.razao_social AS company_name, 
con.cnpj AS cnpj, 
con.nome_fantasia AS trading_name, 
con.endereco AS address, 
con.complemento AS complement,
con.bairro AS neighborhood, 
con.cep AS zip, 
con.cidade AS city, 
con.estado AS state, 
con.representante1 AS agent1_name, 
con.rep1_cpf AS agent1_cpf, 
con.rep1_telefone AS agent1_telephone,
con.representante2 AS agent2_name, 
con.rep2_cpf AS agent2_cpf, 
con.rep2_telefone AS agent2_telephone, 
con.banco AS bank_name, 
con.banco_numero AS bank_number, 
con.banco_titular AS bank_holder,
con.banco_agencia AS bank_agency, 
con.banco_conta AS bank_account, 
con.banco_cpf_cnpj AS bank_cpf_cnpj, 
con.banco_financeiro_email AS bank_financial_email, 
con.assinado AS is_signed, 
con.enviado AS is_sent,
(80000+con.consultor_id) AS consultant_id, 
DATE_FORMAT(con.prazo_inicio, '%Y-%m-%d') AS initial_term, 
DATE_FORMAT(con.prazo_fim, '%Y-%m-%d') AS final_term, 
con.restricao AS restriction, 
con.agendamento AS has_scheduling, 
con.agend_contato AS sched_contact, 
DATE_FORMAT(con.agend_data_max, '%Y-%m-%d') AS sched_max_date,
con.agend_datas AS sched_dates, 
con.agend_antecedencia_min AS sched_min_antecedence, 
con.pessoas AS n_people, 
con.destaques AS features, 
con.regras AS rules, 
REPLACE( IFNULL(con.clausulas, ''), '\n' , ' ' ) AS clauses,
con.ip AS ip, 
DATE_FORMAT(con.datahora_assinatura , '%Y-%m-%d %H:%i:%s') AS signed_at, 
DATE_FORMAT(con.datahora_criacao , '%Y-%m-%d %H:%i:%s') AS created_at, 
DATE_FORMAT(con.datahora , '%Y-%m-%d %H:%i:%s') AS updated_at

FROM contratos AS con

WHERE con.id > 182

INTO OUTFILE "/tmp/contracts.csv"
CHARACTER SET 'LATIN1'
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '¨' ESCAPED BY ''
LINES TERMINATED BY "\n";
