<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>INNBatível - Viaje mais por menos</title>
</head>
<body>
<h1>CONTE PRA GENTE</h1>
<p>
    Ol&aacute; {{ $name }}, <br /> <br />
    Obrigado por compartilhar sua experi&ecirc;ncia conosco.
<hr>
<p>
    <b>Nome: </b>{{ $name }}<br />
    <b>E-mail: </b>{{ $email }}<br />
    <b>Destino: </b>{{ $destiny }}<br />
    <b>Data da Viagem: </b>{{ $travel_date }}<br />
    <b>Depoimento: </b><pre>{{ $depoiment }}</pre><br />
    <b>{{ link_to($img_url, "Foto") }}</b><br />
</p>
</body>
</html>