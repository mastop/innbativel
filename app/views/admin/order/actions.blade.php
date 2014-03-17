<div id="user-actions">
	<ul class="round-buttons">
		<li><div class="depth"><a href="{{ route('admin.user') }}"><i class="icon-reorder"></i></a></div></li>
		<li><div class="depth"><a href="{{ route('admin.user.create') }}"><i class="icon-plus"></i></a></div></li>
	</ul>
</div>

<div id="user-filters" class="row-fluid">
	<div class="pa">
	{{ Former::inline_open()->method('GET') }}
	{{ Former::text('email')->class('input-medium')->placeholder('E-mail') }}
	{{ Former::text('cpf')->class('input-medium')->placeholder('CPF') }}
	{{ Former::submit('Filtrar Resultados') }}
	{{ Former::close() }}
	</div>
</div>

<div id="user-statistics">
	<ul class="statistics">
		<li>
			<div class="top-info">
				<a href="#" title="" class="blue-square"><i class="icon-plus"></i></a>
				<strong>1k</strong>
			</div>
			<div class="progress progress-micro"><div class="bar" style="width: 60%;"></div></div>
			<span>Novos Usuários</span>
		</li>
		<li>
			<div class="top-info">
				<a href="#" title="" class="sea-square"><i class="icon-group"></i></a>
				<strong>2K+</strong>
			</div>
			<div class="progress progress-micro"><div class="bar" style="width: 50%;"></div></div>
			<span>Total de Usuários</span>
		</li>
		<li>
			<div class="top-info">
				<a href="#" title="" class="dark-blue-square"><i class="icon-facebook"></i></a>
				<strong>3k</strong>
			</div>
			<div class="progress progress-micro"><div class="bar" style="width: 93%;"></div></div>
			<span>Facebook fans</span>
		</li>
	</ul>
</div>


<ul class="action-tabs">
	<li><a href="#user-actions" title="">Ações</a></li>
	<li><a href="#user-filters" title="">Filtros</a></li>
	<li><a href="#user-statistics" title="">Estatísticas</a></li>
</ul>
