<ofertas xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="http://xml.saveme.com.br/xsd/ofertas.xsd">
@foreach ($offers as $offer)

	<?php
	$offer_option = $offer->offer_option->get(0);

	$rules = strip_tags($offer->general_rules,'<br>,<li>');
	$rules .= '<br>' . strip_tags($offer_option['rules'],'<br>,<li>');
    preg_match_all("#<li>(.*?)<\/li>#s", $rules, $rules);
	?>

	<oferta>
        <id>{{ $offer->id }}</id>
        <titulo><![CDATA[{{ $offer->destiny }} | {{ $offer->saveme_title }}]]></titulo>
        <preco-real>{{ $offer_option['price_original'] }}</preco-real>
        <preco-final>{{ $offer_option['price_with_discount'] }}</preco-final>
        <desconto>{{ $offer->percent_off }}</desconto>
        <url-imagem><![CDATA[{{ $offer->saveme_img }}]]></url-imagem>
        <link><![CDATA[http://www.innbativel.com.br/oferta/{{ $offer->slug }}]]></link>
        <data-inicio>{{ $offer->starts_on }}</data-inicio>
        <data-fim>{{ $offer->ends_on }}</data-fim>
        <categoria>6</categoria>
        <detalhes><![CDATA[{{ $offer->description }}]]></detalhes>
        <regras>
        @foreach ($rules['1'] as $rule)
            <regra><![CDATA[{{ $rule }}]]></regra>
        @endforeach
        </regras>
        <destaques>
        	<destaque><![CDATA[{{ $offer->features }}]]></destaque>
        </destaques>
        <cidades>
        @foreach ($offer->saveme as $saveme)
	        <cidade>
	        	<codigo-cidade>{{ $saveme->geocode }}</codigo-cidade>
	        	<prioridade-cidade>{{ $saveme->priority }}</prioridade-cidade>
        	</cidade>
        @endforeach
        </cidades>
        <estabelecimentos>
	        <estabelecimento>
		        <nome-estabelecimento><![CDATA[{{ $offer->partner->name }}]]></nome-estabelecimento>
		        <tipo-estabelecimento>1</tipo-estabelecimento>
		        <site-estabelecimento>{{ $offer->partner->site }}</site-estabelecimento>
		        <pais-estabelecimento>{{ $offer->partner->country }}</pais-estabelecimento>
		        <cidade-estabelecimento><![CDATA[{{ $offer->partner->city }}]]></cidade-estabelecimento>
		        <estado-estabelecimento><![CDATA[{{ $offer->partner->state }}]]></estado-estabelecimento>
		        <bairro-estabelecimento><![CDATA[{{ $offer->partner->neighborhood }}]]></bairro-estabelecimento>
		        <endereco-estabelecimento><![CDATA[{{ $offer->partner->street }}]]></endereco-estabelecimento>
		        <numero-estabelecimento><![CDATA[{{ $offer->partner->number }}]]></numero-estabelecimento>
		        <complemento-estabelecimento><![CDATA[{{ $offer->partner->complement }}]]></complemento-estabelecimento>
		        <cep-estabelecimento><![CDATA[{{ $offer->partner->zip }}]]></cep-estabelecimento>
		        <ddi-estabelecimento></ddi-estabelecimento>
		        <ddd-estabelecimento></ddd-estabelecimento>
		        <telefone-estabelecimento><![CDATA[{{ $offer->partner->telephone }}]]></telefone-estabelecimento>
	        </estabelecimento>
        </estabelecimentos>
	</oferta>
@endforeach
</ofertas>
