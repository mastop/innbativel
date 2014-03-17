<div id="super-search" class="clearfix">
    {{ Former::inline_open()->method('GET')->rules(['search' => 'required']) }}
    {{ Former::text('search')->label('Para onde você quer ir?') }}
    {{ Former::submit('Buscar') }}
    {{ Former::close() }}
</div>
