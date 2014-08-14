@section('content')

    <div class="well widget row-fluid">

        {{ Former::horizontal_open()->rules([
        	'display_code' => 'required',
            'value' => 'required',
            'qty' => 'required|integer',
            'starts_on' => 'required',
            'ends_on' => 'required',
        ]) }}

        {{ Former::text('display_code', 'Código')->class('span12') }}
        {{ Former::text('value', 'Valor')->class('span12') }}
        {{ Former::number('qty', 'Quantidade máxima')->class('span12') }}
        {{ Former::text('starts_on', 'Início da validade')->class('span12 datepicker') }}
        {{ Former::text('ends_on', 'Fim da validade')->class('span12 datepicker') }}
        {{ Former::select('category_id', 'Categoria')
                 ->addOption('Qualquer', null)
                ->fromQuery(DB::table('categories')->select(['title', 'id']), 'title', 'id')
                ->class('span12')
        }}
        {{ Former::text('user_email', 'E-mail do Usuário (deixe em branco p/ servir a qualquer usuário)')->class('span12') }}
		{{ Former::select('offer_id', 'Oferta')
			 	 ->addOption('Qualquer', null)
			 	 ->fromQuery(DB::table('offers')->where('ends_on', '>=', date("Y-m-d H:i:s"))->select(DB::raw('concat (offers.id," | ",destinies.name) as id_destiny, offers.id as id'))->leftJoin('destinies', 'offers.destiny_id', '=', 'destinies.id'), 'id_destiny', 'id')
				 ->class('span12')
		}}

        {{ Former::actions()
          ->primary_submit('Salvar')
          ->inverse_reset('Limpar') }}

        {{ Former::close() }}

    </div>

@stop
