@section('content')

    <div class="well widget row-fluid">

        {{ Former::horizontal_open()->rules([
        	'name' => 'required',
        ]) }}

        {{ Former::populate($coupon) }}

        {{ Former::text('display_code', 'Código')->class('span12') }}
        {{ Former::text('value', 'Valor')->class('span12') }}
        {{ Former::number('qty', 'Quantidade máxima')->class('span12') }}
        {{ Former::date('starts_on', 'Data início')->class('span12') }}
        {{ Former::date('ends_on', 'Data fim')->class('span12') }}
        {{ Former::select('user_id', 'Usuário')
			 	 ->addOption('-- selecione uma opção --', null)
			 	 ->fromQuery(DB::table('users')->get(['id', 'email']), 'email', 'id')
				 ->class('span12')
		}}
		{{ Former::select('offer_id', 'Oferta')
			 	 ->addOption('-- selecione uma opção --', null)
			 	 ->fromQuery(DB::table('offers')->where('ends_on', '>=', date("Y-m-d H:i:s"))->select(DB::raw('concat (id," | ",destiny) as id_destiny, id')), 'id_destiny', 'id')
				 ->class('span12')
		}}

        {{ Former::actions()
          ->primary_submit('Salvar')
          ->inverse_reset('Limpar') }}

        {{ Former::close() }}

    </div>

@stop
