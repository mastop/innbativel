<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>INNBatível - Viaje mais por menos</title>
</head>
<body>
<h1>SUGIRA UMA VIAGEM</h1>
<p>
    Ol&aacute; Equipe INNBat&iacute;vel, <br /><br />
    {{ $name }} sugeriu uma viagem pelo site, com os seguintes dados:
<hr>
<p>
    <b>Nome: </b>{{ $name }}<br />
    <b>E-mail: </b>{{ $email }}<br />
    <b>Destino: </b>{{ $destiny }}<br />
    <b>Sugest&atilde;o: </b><pre>{{ $suggestion }}</pre><br />
    <br />
    <b>{{ link_to_route('admin.suggest', 'Veja no admin') }}</b>

</p>
</body>
</html>