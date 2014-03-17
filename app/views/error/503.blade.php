@extends('themes.floripa.frontend.html')

@section('content')
<div class="error-page">
    <div class="error-content">
          <h2 class="title">Ops!. Houve algum problema e sua ação não foi concluída.</h2>
          <h3 class="subtitle">Por favor, tente novamente mais tarde ou entre em contato conosco através do e-mail <a href="mailto:faleconosco@innbativel.com.br">faleconosco@innbativel.com.br</a></h3>
          <br>
          <br>
          <br>
          <br>
          <div class="row-fluid error-buttons">
              <a href="{{ url('/') }}" title="" class="btn btn-success span6">Voltar à Página Principal</a>
          </div>
          <br>
          <br>
          <br>
          <br>
          <br>
      </div>
  </div>
@stop
