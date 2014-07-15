<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>INNBatível - Viaje mais por menos</title>
</head>
<body>
<h1>TRABALHE CONOSCO</h1>
<p>
    Ol&aacute; Equipe InnBat&iacute;vel, <br /><br />
    O  {{ $trabalheFullName }} enviou-nos seu interesse em trabalhar conosco, com os seguintes dados:
<hr>
<p>
    <b>Nome completo: </b>{{ $trabalheFullName }}<br />
    <b>Email: </b>{{ $trabalheEmail }}<br />
    <b>Sexo: </b>{{ $trabalheSexo }}<br />
    <b>Telefone: </b>{{ $trabalhePhone }}<br />
    <b>Celular: </b>{{ $trabalheCelular }}<br />
    <b>CEP: </b>{{ $trabalheCEP }}<br />
    <b>Endereço: </b>{{ $trabalheAddress }}<br />
    <b>Complemento: </b>{{ $trabalheAddress2 }}<br />
    <b>Bairro: </b>{{ $trabalheAddressBairro }}<br />
    <b>Cidade: </b>{{ $trabalheAddressCity }}<br />
    <b>Estado: </b>{{ $trabalheAddressState }}<br />
    <b>Atuação: </b>{{ $trabalheAtuacao }}<br />
    <b>{{ link_to($trabalheCV, "Currículo CV") }}</b><br />
</p>
</body>
</html>