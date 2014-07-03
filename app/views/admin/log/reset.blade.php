@section('content')

<div class="widget">
	<div class="datatable-header">
		<div class="dataTables_filter">
			{{ Former::inline_open(route('admin.log.truncate')) }}
			{{ Former::submit('Confirmar ação \'Zerar Logs\'')->class('btn btn-danger') }}
			{{ Former::close() }}
		</div>
	</div>
	{{ Table::open() }}
	{{ Table::headers('ID', 'Tipo', 'Mensagem', 'Criado em', 'Atualizado em') }}
	{{ Table::body($log)}}
	{{ Table::close() }}
</div>

@stop
