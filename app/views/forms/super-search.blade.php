<div id="super-search" class="clearfix">
    {{ Former::inline_open()->method('GET')->rules(['search' => 'required']) }}
    {{ Former::text('search')->label('O que você procura?') }}
    {{ Former::submit('Buscar') }}
    {{ Former::close() }}
</div>
