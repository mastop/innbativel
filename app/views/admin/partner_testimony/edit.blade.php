@section('content')

    <div class="well widget row-fluid">

        {{ Former::open_for_files()->rules([
        	'name' => 'required',
        	'destiny' => 'required',
        	'sponsor' => 'required',
        	'role' => 'required',
			'testimony' => 'required',
        ])
        ->setAttribute('files', true) }}

        {{ Former::populate($partner_testimony) }}

        {{ Former::text('name', 'Parceiro')->class('span12') }}
        {{ Former::text('destiny', 'Destino')->class('span12') }}
        {{ Former::text('sponsor', 'Responsável')->class('span12') }}
        {{ Former::text('role', 'Cargo do responsável')->class('span12') }}
        {{ Former::text('testimony', 'Depoimento')->class('span12') }}

        @if(isset($partner_testimony->img))
            <figure class="span4 form-file-thumb"><img src="{{ $partner_testimony->img }}"></figure>
        @endif

        {{ Former::file('img', 'Imagem (NN x MM)')->accept('png', 'jpg', 'jpeg')->class('span12') }}

        {{ Former::actions()
          ->primary_submit('Salvar')
          ->inverse_reset('Limpar') }}

        {{ Former::close() }}

    </div>

@stop


