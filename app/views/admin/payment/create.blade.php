@section('content')

    <div class="well widget row-fluid">

        {{ Former::horizontal_open()->rules([
            'sales_from' => 'required',
            'sales_to' => 'required',
            'date' => 'required',
        ]) }}

        {{ Former::text('sales_from', 'Vendas de (às 00:00:00)')->class('span12 datepicker') }}
        {{ Former::text('sales_to', 'Vendas até (às 23:59:59)')->class('span12 datepicker') }}
        {{ Former::text('date', 'Data de pagamento')->class('span12 datepicker') }}

        {{ Former::actions()
          ->primary_submit('Enviar')
          ->inverse_reset('Limpar') }}

        {{ Former::close() }}

    </div>

@stop
