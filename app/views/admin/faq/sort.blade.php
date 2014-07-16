@section('content')
<style type="text/css">
.items_sortable{
	min-height: 24px;
	border: 1px solid black;
	padding: 5px;
}
</style>

<div class="widget">
	<div class="navbar">
		<div class="navbar-inner">
			<h6>Ordenar Grupos de FAQs</h6>
	        <div class="nav pull-right">
	            <span class="dropdown-toggle navbar-icon">Grupos de FAQs:</span>
	            <a href="{{ route('admin.faq.group') }}" title="Listar Grupos de FAQs" class="dropdown-toggle navbar-icon"><i class="icon-align-justify"></i></a>
	            <a href="{{ route('admin.faq.group.create') }}" title="Criar Grupo de FAQ" class="dropdown-toggle navbar-icon"><i class="icon-plus"></i></a>
	            <span class="dropdown-toggle navbar-icon">FAQs:</span>
	            <a href="{{ route('admin.faq') }}" title="Listar FAQs" class="dropdown-toggle navbar-icon"><i class="icon-align-justify"></i></a>
	            <a href="{{ route('admin.faq.create') }}" title="Criar FAQ" class="dropdown-toggle navbar-icon"><i class="icon-plus"></i></a>
	            <a href="{{ route('admin.faq.sort') }}" title="Ordenar FAQs" class="dropdown-toggle navbar-icon"><i class="icon-random"></i></a>
	        </div>
		</div>
	</div>
	<div class="well widget row-fluid">
		{{ Former::inline_open(route('admin.faq.save_sort')) }}
		<div id="blocks_sortable">
			@foreach ($groups as $group)
		    <div id="{{ $group->id }}">
		        <h2>{{ $group->title }}</h2>
		        <div class="items_sortable connectedSortable">
		            @foreach($group->faq as $faq)
		            <div class="faq{{ $faq->id }}" id="{{ $faq->id }}"> 
		                <span>{{ $faq->question }}</span>
		                {{ Former::hidden('faqs_groups['.$group->id.'][]')->value($faq->id) }}
		            </div>   
		            @endforeach
		        </div>
		    </div>
			@endforeach

			@if(isset($faqs{0}))
		    <div id="{{ $group->id }}">
		        <h2>FAQs sem grupo</h2>
		        <div class="items_sortable connectedSortable">
		            @foreach($faqs as $faq)
		            <div class="faq{{ $faq->id }}" id="{{ $faq->id }}"> 
		                <span>{{ $faq->question }}</span>
		                {{ Former::hidden('faqs_groups[0][]')->value($faq->id) }}
		            </div>   
		            @endforeach
		        </div>
		    </div>
			@endif
		</div>
	    {{ Former::submit('Enviar') }}
		{{ Former::link('Resetar', route('admin.offer.sort')) }}

	    {{ Former::close() }}
	</div>
</div>
<script type="text/javascript">
	$("#blocks_sortable").sortable();
	$(".items_sortable").sortable({
        connectWith: '.connectedSortable',
        forcePlaceholderSize: true,
        update: function(event, ui){
            if(ui.sender){
            	var faq_class = ui.item.attr("class");
            	var faq_id = ui.item.attr("id");
            	var group_id = $(this).parent().attr("id");

                // alert("faq" + faq_id + " in group" + group_id);

            	$('.'+faq_class+' [value='+faq_id+']').attr('name', 'faqs_groups['+group_id+'][]');
            }
        }
    }).disableSelection();
</script>
@stop
