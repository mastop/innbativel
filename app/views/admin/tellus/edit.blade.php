@section('content')

    <div class="well widget row-fluid">

        {{ Former::horizontal_open()->rules([
        	'name' => 'required',
        	'destiny' => 'required',
        	'partner_name' => 'required',
        	'travel_date' => 'required',
			'depoiment' => 'required',
			'img' => 'required',
        ]) }}

        {{ Former::populate($tellus) }}

        {{ Former::text('name', 'Nome')->class('span12') }}
        {{ Former::text('destiny', 'Destino')->class('span12') }}
        {{ Former::text('partner_name', 'Parceiro')->class('span12') }}
        {{ Former::date('travel_date', 'Data da viagem')->class('span12') }}
        {{ Former::text('depoiment', 'Depoimento')->class('span12') }}


        @if(isset($tellus->img) && !is_null($tellus->img) && !empty($tellus->img))
			<figure class="span4 form-file-thumb"><img src="{{ asset($tellus->img) }}"></figure>
			<div class="span4">
				<a href="{{ route('admin.tellus.clearfield', [$tellus->id, 'img']) }}" class="btn btn-danger tip" title="Alterar Imagem">
					<i class="icon-trash"></i>
				</a>
			</div>
		@else
			{{ Former::file('img', 'Imagem (NN x MM)')->accept('png', 'jpg', 'jpeg')->class('span12') }}
		@endif

        {{ Former::actions()
          ->primary_submit('Salvar')
          ->inverse_reset('Limpar') }}

        {{ Former::close() }}

    </div>

@stop


