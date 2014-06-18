@extends('themes.floripa.frontend.html')

@section('content')
  <div id="main" class="container error-page">
    
    <div class="row">

      <div class="col-12 col-sm-12 col-lg-12">
        <img src="assets/images/404.png">
        <h2>Ops... página INNexistente</h2>
        <h4>A página que você procura não está aqui, mas pelo menos você encontrou nosso gatinho perdido!</h4>
        <p>
          Verifique se o endereço está correto e tente recarregar a página, ou desencane e <a href="{{ route('home') }}">confira nossas ofertas</a>.
        </p>
        <p>
          Se você buscava algo específico e acabou parando aqui, por favor <a href="#contact" data-toggle="modal">entre em contato conosco</a> e conte-nos o que houve. Assim poderemos melhorar sua experiência.
        </p>
        <p>
          Nosso gato INNdomável agradece!
        </p>
      </div>

    </div>
  </div>
@stop
