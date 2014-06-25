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
    <p>{{ $msg }}</p>
</p>
