@section('content')

    <script src="{{ asset_timed('assets/vendor/jquery.mask/jquery.mask.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#sales_from').mask('0000-00-00 00:00:00');
            $('#sales_to').mask('0000-00-00 00:00:00');
            $('#date').mask('0000-00-00');
        });
    </script>

    <div class="well widget row-fluid">

        {{ Former::horizontal_open()->rules([
            'sales_from' => 'required|date_format:Y-m-d H:i:s',
            'sales_to' => 'required|date_format:Y-m-d H:i:s',
            'date' => 'required|date_format:Y-m-d|after:'.date('Y-m-d'),
        ]) }}

        {{ Former::populate($payment) }}

        {{ Former::text('sales_from', 'Vendas de')->class('span12')->placeholder(' Formato: ano-mês-dia hora:minuto:segundo') }}
        {{ Former::text('sales_to', 'Vendas até')->class('span12')->placeholder(' Formato: ano-mês-dia hora:minuto:segundo') }}
        {{ Former::text('date', 'Data de pagamento')->class('span12')->placeholder(' Formato: ano-mês-dia') }}

        {{ Former::actions()
          ->primary_submit('Enviar')
          ->inverse_reset('Limpar') }}

        {{ Former::close() }}

    </div>

@stop
