<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>INNBatível - Viaje mais por menos</title>
<style type="text/css">
a, a:link, a:visited, a:hover, a:focus, a:active{
  color: #f0cf31;
}
</style>
</head>
<body>
<p><img src="https://{{Configuration::get("s3url")}}/logo.png"/></p>
<p>
  Ol&aacute; {{ $name }},<br /><br />
  Confirmamos o recebimento de seu e-mail. Em breve entraremos em contato.
</p>
<p>
    <b>Nome:</b> {{ $name }}<br />
    <b>E-mail:</b> {{ $email }}<br />
    <b>Telefone:</b> {{ $telefone }}<br />
    <b>Celular:</b> {{ $celuar }}<br />
    <b>P&aacute;gina:</b> {{ isset($url) ? link_to($url, $url) : '' }}<br />
    <p><pre>{{ $msg }}</pre></p><br />

	Atenciosamente,<br />
	Equipe INNBat&iacute;vel
</p>
</body>
</html>