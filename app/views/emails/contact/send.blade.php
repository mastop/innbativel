<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>INNBatível - Viaje mais por menos</title>
</head>
<body>
<h1>FALE CONOSCO</h1>
<p>
  Ol&aacute; Equipe InnBat&iacute;vel, <br /><br />
  O  {{ $name }}, entrou em contato pelo fale conosco do site, com os seguintes dados:
<hr>
<p>
    <b>Nome:</b> {{ $name }}<br />
    <b>E-mail:</b> {{ $email }}<br />
    <b>Telefone:</b> {{ $telefone }}<br />
    <b>Celular:</b> {{ $celuar }}<br />
    <b>P&aacute;gina:</b> {{ isset($url) ? link_to($url, $url) : '' }}<br />
    <p><pre>{{ $msg }}</pre></p>
</p>
</body>
</html>