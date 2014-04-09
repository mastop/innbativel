@section('content')
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Imprimir contrato INNBatível</title>
<style>
.content {
    margin:0;
    padding:0;
    font-family: "Arial";
    font-size: 12px;
    line-height: 1.4;
    margin:50px;
}

table {
    font-family: verdana,arial,sans-serif;
    font-size:11px;
    color:#333333;
    border-width: 1px;
    border-color: #666666;
    border-collapse: collapse;
}
table th {
    border-width: 1px;
    padding: 8px;
    border-style: solid;
    border-color: #666666;
    background-color: #dedede;
}
table td {
    border-width: 1px;
    padding: 8px;
    border-style: solid;
    border-color: #666666;
    background-color: #ffffff;
}

tr.grey {
    background: #eee;
}
</style>
</head>

<body>

<div class="content">
<img src="http://innb.s3.amazonaws.com/1397062768.png"/><br/>
<h1>Contrato INNBatível</h1>

<h3>Identificação</h3>

<p><label>ID do contrato: {{ $contract->id }}</label></p>

<h3>Empresa</h3>

<p><label>Nome: {{ $contract->partner->first_name.(isset($contract->partner->last_name)?(' '.$contract->partner->last_name):'') }}</label></p>

<h3>Consultor INNBatível</h3>

<p><label>Nome: {{ $contract->consultant->first_name.(isset($contract->consultant->last_name)?(' '.$contract->consultant->last_name):'') }}</label></p>

<h3>Dados do contratante</h3>

<p><label>Razão social: {{ $contract->company_name }}</label></p>
<p><label>CNPJ: {{ $contract->cnpj }}</label></p>
<p><label>Nome fantasia: {{ $contract->trading_name }}</label></p>
<p><label>Endereço: {{ $contract->address }}</label></p>
<p><label>Complemento: {{ $contract->complement }}</label></p>
<p><label>Bairro: {{ $contract->neighborhood }}</label></p>
<p><label>CEP: {{ $contract->zip }}</label></p>
<p><label>Cidade: {{ $contract->city }}</label></p>
<p><label>Estado: {{ $contract->state }}</label></p>

<h3>Representantes legais com poderes previstos no Contrato Social</h3>

<p><label>Representante 1: {{ $contract->agent1_name }}</label></p>
<p><label>CPF representante 1: {{ $contract->agent1_cpf }}</label></p>
<p><label>Telefone representante 1: {{ $contract->agent1_telephone }}</label></p>
<p><label>Representante 2: {{ $contract->agent2_name }}</label></p>
<p><label>CPF representante 2: {{ $contract->agent2_cpf }}</label></p>
<p><label>Telefone representante 2: {{ $contract->agent2_telephone }}</label></p>

<h3>Dados Bancários (Devem necessariamente ser dados vinculados ao CNPJ e Razão Social acima)</h3>

<p><label>Banco: {{ $contract->bank_name }}</label></p>
<p><label>Número do banco: {{ $contract->bank_number }}</label></p>
<p><label>Títular: {{ $contract->bank_holder }}</label></p>
<p><label>Agência: {{ $contract->bank_agency }}</label></p>
<p><label>Conta: {{ $contract->bank_account }}</label></p>
<p><label>CPF ou CNPJ: {{ $contract->bank_cpf_cnpj }}</label></p>
<p><label>E-mail Dpto financeiro: {{ $contract->bank_financial_email }}</label></p>

<h3>Regras de uso do Cupom</h3>

<p><label>Prazo de utilização, início: {{ date('d/m/Y', strtotime($contract->initial_term)) }}</label></p>
<p><label>Prazo de utilização, fim: {{ date('d/m/Y', strtotime($contract->final_term)) }}</label></p>
<p><label>Nº de Pessoas por cupom: {{ $contract->n_people }}</label></p>
<p><label>Restrição: {{ $contract->restriction }}</label></p>

<p><label>Agendamento? {{ (($contract->has_scheduling == 1)?'Sim':'Não') }}</label></p>

<span id="agend_continuacao">
    <p><label>Telefone, e-mail e/ou site para agendamento: {{ $contract->sched_contact }}</label></p>
    <p><label>Dias e horários para agendamento: {{ $contract->sched_dates }}</label></p>
    <p><label>Data limite para agendamento, se existir: <?php if($contract->sched_max_date != '0000-00-00'){  echo date('d/m/Y', strtotime($contract->sched_max_date)); } ?></label></p>
    <p><label>Antecedência mínima para agendamento:  {{ $contract->sched_min_atecedence }}</label></p>
</span>

<?php if($contract->has_scheduling == false){ ?><script type="text/javascript">$('#agend_continuacao').hide()</script><?php } ?>

<h3>Detalhamento dos serviços oferecidos</h3>

<p><label>Destaques:<br/>{{ $contract->features; }}</label></p>
<p><label>Regras:<br/>{{ $contract->rules; }}</label></p>

<table>
    <thead>
        <tr>
            <th>Opção da oferta</th>
            <th>Preço original (R$)</th>
            <th>Preço final (R$)</th>
            <th>Desconto oferecido ao usuário (%)</th>
            <th>Valor repasse por cupom (R$)</th>
            <th>Número máximo de cupons</th>
        </tr>
    </thead>
    <tbody>

    <?php $cont = 0; ?>

    @foreach($contract_options AS $contract_option)
    <?php $classe = (($cont)%2 == '0')?'class="grey"':''; ?>
    <tr {{ $classe }}>
        <td>{{ $contract_option->title }}</td>
        <td>{{ number_format($contract_option->price_original, 2, ',', '.') }}</td>
        <td>{{ number_format($contract_option->price_with_discount, 2, ',', '.') }}</td>
        <td>{{ $contract_option->percent_off }}</td>
        <td>{{ number_format($contract_option->trasfer, 2, ',', '.') }}</td>
        <td>{{ $contract_option->max_qty }}</td>
    </tr>
    <?php $cont++; ?>
    @endforeach
</table>


<p><label>Parceiro concorda que o Preço Final será definido a critério do INNBatível, podendo ser modificado a qualquer tempo.</label></p>

<h3>Cláusulas</h3>

<p>{{ $contract->clauses }}</label></p><br/>

<h3>Outros dados</h3>

<p><label>Contrato assinado? <b>{{ (($contract->assinado == true)?'Sim':'Não') }}</b></label></p>
<p><label>IP do anunciante parceiro no momento da assinatura: {{ $contract->ip }}</label></p>
<p><label>Contrato assinado em: {{ (($contract->assinado == true)?date("d/m/Y H:i:s", strtotime($contract->datahora_assinatura)):'-') }}</label></p>
<p><label>Contrato criado em: {{ date("d/m/Y H:i:s", strtotime($contract->datahora_criacao)) }}</label></p>
<p><label>Última atualização: {{ date("d/m/Y H:i:s", strtotime($contract->datahora)) }}</label></p>

</div>
<script type="text/javascript">window.print();</script>
</body>
</html>
@stop