@section('content')

    <div class="well widget row-fluid">

        {{ Former::horizontal_open()->rules([
        	'name' => 'required',
        ]) }}

        {{ Former::text('display_code', 'Código')->class('span12') }}
        {{ Former::text('value', 'Valor')->class('span12') }}
        {{ Former::number('qty', 'Quantidade máxima')->class('span12') }}
        {{ Former::date('starts_on', 'Data início')->class('span12') }}
        {{ Former::date('ends_on', 'Data fim')->class('span12') }}
        {{ Former::text('user_email', 'E-mail do Usuário')->class('span12') }}
		{{ Former::select('offer_id', 'Oferta')
			 	 ->addOption('-- selecione uma opção --', null)
			 	 ->fromQuery(DB::table('offers')->where('ends_on', '>=', date("Y-m-d H:i:s"))->select(DB::raw('concat (offers.id," | ",destinies.name) as id_destiny, offers.id as id'))->leftJoin('destinies', 'offers.destiny_id', '=', 'destinies.id'), 'id_destiny', 'id')
				 ->class('span12')
		}}

        {{ Former::actions()
          ->primary_submit('Salvar')
          ->inverse_reset('Limpar') }}

        {{ Former::close() }}

    </div>

@stop
