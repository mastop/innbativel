<div id="super-search" class="clearfix">
    {{ Former::inline_open()->method('GET')->rules(['q' => 'required']) }}
    {{ Former::text('q')->label('Para onde você quer ir?')->value(Input::get('q')) }}
    {{ Former::submit('Buscar') }}
    {{ Former::close() }}
</div>
