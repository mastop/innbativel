@section('content')

    <script src="{{ asset('assets/vendor/jquery.mask/jquery.mask.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#sales_from').mask('00/00/0000 00:00:00');
            $('#sales_to').mask('00/00/0000 00:00:00');
            $('#date').mask('00/00/0000');
        });
    </script>

    <div class="well widget row-fluid">

        {{ Former::horizontal_open()->rules([
        	'sales_from' => 'required|date_format:d/m/Y H:i:s',
            'sales_to' => 'required|date_format:d/m/Y H:i:s',
            'date' => 'required|date_format:d/m/Y|after:'.date('d-m-Y'),
        ]) }}

        {{ Former::text('sales_from', 'Vendas de')->class('span12')->placeholder(' d-m-a h:m:s') }}
        {{ Former::text('sales_to', 'Vendas até')->class('span12')->placeholder(' d-m-a h:m:s') }}
        {{ Former::text('date', 'Data de pagamento')->class('span12')->placeholder(' d-m-a') }}

        {{ Former::actions()
          ->primary_submit('Enviar')
          ->inverse_reset('Limpar') }}

        {{ Former::close() }}

    </div>

@stop
