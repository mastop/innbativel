@section('content')

    <div class="well widget row-fluid">

        {{ Former::horizontal_open()->rules([
        	'name' => 'required',
        	'icon_url' => 'required',
        ]) }}

        {{ Former::populate($genre) }}

        {{ Former::text('name', 'Nome')->class('span12') }}


        @if(isset($genre->icon_url) && !is_null($genre->icon_url) && !empty($genre->icon_url))
			<figure class="span4 form-file-thumb"><img src="{{ asset($genre->icon_url) }}"></figure>
			<div class="span4">
				<a href="{{ route('admin.genre.clearfield', [$genre->id, 'icon_url']) }}" class="btn btn-danger tip" title="Alterar Imagem">
					<i class="icon-trash"></i>
				</a>
			</div>
		@else
			{{ Former::file('icon_url', 'Imagem (NN x MM)')->accept('png', 'jpg', 'jpeg')->class('span12') }}
		@endif

        {{ Former::actions()
          ->primary_submit('Salvar')
          ->inverse_reset('Limpar') }}

        {{ Former::close() }}

    </div>

@stop


