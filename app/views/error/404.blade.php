@extends('themes.floripa.frontend.html')

@section('content')
<div class="error-page">
    <div class="error-content">
          <h2 class="title">A Página solicitada não foi encontrada</h2>
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
