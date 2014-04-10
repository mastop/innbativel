@section('content')

<header id="top">
    <div class="fixed">
        @include('menu.painel')
    </div>
</header>

{{ Typography::horizontal_dl($orderData) }}

@stop
