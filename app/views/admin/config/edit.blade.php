@section('content')

    <div class="well widget row-fluid">

        {{ Former::horizontal_open()->rules([
        	'name' => 'required',
        	'value' => 'required',
        ]) }}

        {{ Former::populate($config) }}

        {{ Former::text('name', 'Nome')->class('span12') }}
        {{ Former::textarea('value', 'Valor')->class('span12') }}

        {{ Former::actions()
          ->primary_submit('Enviar')
          ->inverse_reset('Limpar') }}

        {{ Former::close() }}

    </div>

    {{ HTML::script('assets/vendor/tinymce/tinymce.min.js') }}
    <script type="text/javascript">tinymce.init({forced_root_block : "", selector:'textarea'});</script>

@stop
