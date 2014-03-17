@section('content')

    <div class="well widget row-fluid">

        {{ Former::horizontal_open()->rules([
        	'name' => 'required',
        	'destiny' => 'required',
        	'sponsor' => 'required',
        	'role' => 'required',
			'testimony' => 'required',
			'img' => 'required',
        ]) }}

        {{ Former::populate($partner_testimony) }}

        {{ Former::text('name', 'Parceiro')->class('span12') }}
        {{ Former::text('destiny', 'Destino')->class('span12') }}
        {{ Former::text('sponsor', 'Responsável')->class('span12') }}
        {{ Former::text('role', 'Cargo do responsável')->class('span12') }}
        {{ Former::text('testimony', 'Depoimento')->class('span12') }}

        @if(isset($partner_testimony->img) && !is_null($partner_testimony->img) && !empty($partner_testimony->img))
			<figure class="span4 form-file-thumb"><img src="{{ asset($partner_testimony->img) }}"></figure>
			<div class="span4">
				<a href="{{ route('admin.tellus.clearfield', [$partner_testimony->id, 'img']) }}" class="btn btn-danger tip" title="Alterar Imagem">
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


