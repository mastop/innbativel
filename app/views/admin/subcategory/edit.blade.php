@section('content')

    <div class="well widget row-fluid">

        {{ Former::horizontal_open()->rules([
        	'title' => 'required',
        ]) }}

        {{ Former::populate($subcategory) }}

        {{ Former::text('title', 'Título')->class('span12') }}
        {{ Former::select('category_id', 'Categoria')
				 ->fromQuery(DB::table('categories')->get(['id', 'title']), 'title', 'id')
				 ->class('span12')
		}}
		{{ Former::select('is_active', 'Ativa?')
	        	 ->addOption('Sim', 1)
	        	 ->addOption('Não', 0)
	    }}
        {{ Former::actions()
          ->primary_submit('Salvar')
          ->inverse_reset('Limpar') }}

        {{ Former::close() }}

    </div>

@stop
