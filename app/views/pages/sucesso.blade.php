@section('content')
	<div id="main" class="container">

		@if($status == 'pago')
			<h1>Compra efetuada com sucesso</h1>
			<p>
				Seu cupom já está disponível em <a href="https://www.innbativel.com.br/area-do-usuario-meus-cupons.php">sua conta</a>. Acesse e imprima seu cupom agora mesmo.
				<br/>
				Obrigado por comprar no INNBatível. Desejamos uma ótima viajem!
				<br/>
				<br/>
				<br/>
				Por favor, responda à <a href="https://www.ebitempresa.com.br/bitrate/pesquisa1.asp?empresa=1407475" target="_blank">esta pesquisa</a> e ajude-nos a lhe atendermos cada vez melhor.
			</p>
		@elseif($status == 'pendente')
			<h1>Aguardando pagamento</h1>
			<p>
				Obrigado por comprar no INNBatível!
				<br/>
				Assim que identificarmos o seu pagamento, seu cupom será liberado.
				<br/>
				<a href="{{ $boletus_url }}" target="_blank">Acesse aqui o boleto de pagamento</a>
				<br/>
				<br/>
				<br/>
				Por favor, responda à <a href="https://www.ebitempresa.com.br/bitrate/pesquisa1.asp?empresa=1407475" target="_blank">esta pesquisa</a> e ajude-nos a lhe atendermos cada vez melhor.
			</p>
		@else {{-- revisao --}}
			<h1>Pagamento em análise</h1>
			<p>
				Obrigado por comprar no INNbatível! Seu pagamento está em análise. Em até 48h você receberá um email com a liberação de seu cupom, assim que seu pagamento for aprovado.
				<br/>
				<br/>
				<br/>
				Por favor, responda à <a href="https://www.ebitempresa.com.br/bitrate/pesquisa1.asp?empresa=1407475" target="_blank">esta pesquisa</a> e ajude-nos a lhe atendermos cada vez melhor.
			</p>
		@endif
		
		<br>
		<p>
			<a href="https://www.ebitempresa.com.br/bitrate/pesquisa1.asp?empresa=1407475">
			    <img src="http://innb.s3.amazonaws.com/1402943476.gif">
			</a> 
		</p>

	</div>
@stop
