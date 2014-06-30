@section('content')
	<div id="main" class="container">

		@if($status == 'pago')
			<h1>Compra efetuada com sucesso</h1>
			<p>
				Seu cupom já está disponível em <a href="https://www.innbativel.com.br/area-do-usuario-meus-cupons.php">sua conta</a>. Acesse e imprima seu cupom agora mesmo.
				<br/>
				Obrigado por comprar no INNBatível. Desejamos uma ótima viajem!
		@elseif($status == 'pendente')
			<h1>Aguardando pagamento</h1>
			<p>
				Obrigado por comprar no INNBatível!
				<br/>
				Assim que identificarmos o seu pagamento, seu cupom será liberado.
				<br/>
				<a href="{{ $boletus_url }}" target="_blank">Acesse aqui o boleto de pagamento</a>
		@else {{-- revisao --}}
			<h1>Pagamento em análise</h1>
			<p>
				Obrigado por comprar no INNbatível! Seu pagamento está em análise. Em até 48h você receberá um email com a liberação de seu cupom, assim que seu pagamento for aprovado.
		@endif

			<br/>
			<br/>
			Participe da <a href="https://www.ebitempresa.com.br/bitrate/pesquisa1.asp?empresa=1407475" target="_blank">pesquisa e-Bit</a> e concorra a um iPad!
			<br/>
			<br/>
			Nós do INNBatível queremos que você dê sua opinião sobre a experiência de compra em nosso site.
			<br/>
			<br/>
			Será um prazer poder ouvir tudo o que tem para nos dizer, isso só fará com que possamos melhorar mais a cada dia e é claro, estaremos sempre na torcida para que seja VOCÊ um dos ganhadores dos super prêmios oferecidos pelo e-Bit.
			<br/>
			<br/>
			<a href="https://www.ebitempresa.com.br/bitrate/pesquisa1.asp?empresa=1407475" target="_blank">Faça agora sua avaliação na pesquisa e-Bit!</a>
		</p>
		
		<br/>
		<p>
			<a href="https://www.ebitempresa.com.br/bitrate/pesquisa1.asp?empresa=1407475">
			    <img src="//innbativel.s3.amazonaws.com/pesquisa-ebit.gif">
			</a> 
		</p>

	</div>
@stop
