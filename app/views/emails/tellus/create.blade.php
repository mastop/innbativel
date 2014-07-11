<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>INNBatível - Viaje mais por menos</title>
</head>
<body>
<h1>CONTE PRA GENTE</h1>
<p>
    Ol&aacute; Equipe InnBat&iacute;vel, <br /><br />
    O  {{ $name }}, contou sua experi&ecirc;ncia conosco:
<hr>
<p>
    <b>Nome: </b>{{ $name }}<br />
    <b>E-mail: </b>{{ $email }}<br />
    <b>Destino: </b>{{ $destiny }}<br />
    <b>Data da Viagem: </b>{{ $travel_date }}<br />
    <b>Depoimento: </b>{{ $depoiment }}<br />
    <b>{{ link_to($img_url, "Foto") }}</b><br />
    <br />
    <b>{{ link_to_route('admin.tellus', 'Veja no admin') }}</b>
</p>
</body>
</html>