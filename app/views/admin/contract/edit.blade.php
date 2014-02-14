@section('content')

    <div class="well widget row-fluid">

        {{ Former::horizontal_open()->rules([
        	'name' => 'required',
        	'description' => 'required',
        	'img' => 'required',
        ]) }}

        {{ Former::populate($ngo) }}

        {{ Former::text('name', 'Nome')->class('span12') }}
        {{ Former::text('description', 'Descrição')->class('span12') }}


        @if(isset($ngo->img) && !is_null($ngo->img) && !empty($ngo->img))
			<figure class="span4 form-file-thumb"><img src="{{ asset($ngo->img) }}"></figure>
			<div class="span4">
				<a href="{{ route('admin.ngo.clearfield', [$ngo->id, 'img']) }}" class="btn btn-danger tip" title="Alterar Imagem">
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


