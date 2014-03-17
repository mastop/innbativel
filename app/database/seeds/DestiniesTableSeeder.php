<?php

class DestiniesTableSeeder extends DatabaseSeeder
{
  public function run()
  {
    $destinies = [
		[
		  'name' => 'Angra dos Reis - RJ',
		],
		[
		  'name' => 'Aquiraz - CE',
		],
		[
		  'name' => 'Arraial d\'Ajuda - BA',
		],
		[
		  'name' => 'Aruba e Panamá',
		],
		[
		  'name' => 'Bal. Camboriú e Blumenau',
		],
		[
		  'name' => 'Balneário Camboriú - SC',
		],
		[
		  'name' => 'Balneário Escarpas do Lago - MG',
		],
		[
		  'name' => 'Bariloche - ARG',
		],
		[
		  'name' => 'Batismo Ilha do Arvoredo - SC',
		],
		[
		  'name' => 'Búzios - RJ',
		],
		[
		  'name' => 'Beberibe - CE',
		],
		[
		  'name' => 'Bertioga - SP',
		],
		[
		  'name' => 'Blumenau - SC',
		],
		[
		  'name' => 'Bombinhas - SC',
		],
		[
		  'name' => 'Bonito - MS',
		],
		[
		  'name' => 'Buenos Aires - ARG',
		],
		[
		  'name' => 'Buenos Aires e Bariloche',
		],
		[
		  'name' => 'Buenos Aires e Montevidéu',
		],
		[
		  'name' => 'Buenos Aires e Santiago do Chile',
		],
		[
		  'name' => 'Buenos Aires, Montevidéu e Punta del Este',
		],
		[
		  'name' => 'Caldas Novas - GO',
		],
		[
		  'name' => 'Cambará do Sul - RS',
		],
		[
		  'name' => 'Camburi - SP',
		],
		[
		  'name' => 'Campos do Jordão - SP',
		],
		[
		  'name' => 'Cancun - MEX',
		],
		[
		  'name' => 'Canela - RS',
		],
		[
		  'name' => 'Caraguatatuba - SP',
		],
		[
		  'name' => 'Cartagena - COL',
		],
		[
		  'name' => 'Chapada dos Veadeiros - GO',
		],
		[
		  'name' => 'Cusco - Peru',
		],
		[
		  'name' => 'Fernando de Noronha - PE',
		],
		[
		  'name' => 'Florianópolis - SC',
		],
		[
		  'name' => 'Fortaleza - CE',
		],
		[
		  'name' => 'Foz do Iguaçu - PR',
		],
		[
		  'name' => 'Fraiburgo - SC',
		],
		[
		  'name' => 'França e Grécia - EUR',
		],
		[
		  'name' => 'Gramado - RS',
		],
		[
		  'name' => 'Gramado e Canela - RS',
		],
		[
		  'name' => 'Gramado ou Florianópolis',
		],
		[
		  'name' => 'Gravatal - SC',
		],
		[
		  'name' => 'Guarujá - SP',
		],
		[
		  'name' => 'Icaraizinho - CE',
		],
		[
		  'name' => 'Ilhabela - SP',
		],
		[
		  'name' => 'Imbituba - SC',
		],
		[
		  'name' => 'Itacaré - BA',
		],
		[
		  'name' => 'Itália - EUR',
		],
		[
		  'name' => 'Joaquina - Florianópolis',
		],
		[
		  'name' => 'Juqueí - SP',
		],
		[
		  'name' => 'Lages - SC',
		],
		[
		  'name' => 'Laguna - SC',
		],
		[
		  'name' => 'Las Vegas - EUA',
		],
		[
		  'name' => 'Lençóis Maranhenses - MA',
		],
		[
		  'name' => 'Lima, Cusco e Machu Picchu - PER',
		],
		[
		  'name' => 'Lisboa - Portugal',
		],
		[
		  'name' => 'Litoral Paulista',
		],
		[
		  'name' => 'Los Angeles, San Diego e Las Vegas - EUA',
		],
		[
		  'name' => 'Maceió - AL',
		],
		[
		  'name' => 'Machu Picchu - Peru',
		],
		[
		  'name' => 'Machu Picchu, Lima e Cusco - PER',
		],
		[
		  'name' => 'Madri - Espanha',
		],
		[
		  'name' => 'Maragogi - AL',
		],
		[
		  'name' => 'Maresias - SP',
		],
		[
		  'name' => 'Miami e Cancun',
		],
		[
		  'name' => 'Miami e Orlando - EUA',
		],
		[
		  'name' => 'Miami, Orlando e New York - EUA',
		],
		[
		  'name' => 'Miami, Orlando e Las Vegas - EUA',
		],
		[
		  'name' => 'Monte Verde - MG',
		],
		[
		  'name' => 'Montevidéu e Punta Del Este - URU',
		],
		[
		  'name' => 'Morro de São Paulo - Bahia',
		],
		[
		  'name' => 'Mucuri - BA',
		],
		[
		  'name' => 'Natal - RN',
		],
		[
		  'name' => 'Navegantes - SC',
		],
		[
		  'name' => 'New York - EUA',
		],
		[
		  'name' => 'New York e Orlando - EUA',
		],
		[
		  'name' => 'Nova Iorque e Orlando - EUA',
		],
		[
		  'name' => 'Olímpia - SP',
		],
		[
		  'name' => 'Orlando - EUA',
		],
		[
		  'name' => 'Paraty - RJ',
		],
		[
		  'name' => 'Paris & Roma - EUR',
		],
		[
		  'name' => 'Paris - FRA',
		],
		[
		  'name' => 'Paris e Istambul',
		],
		[
		  'name' => 'Paris e Londres - EUR',
		],
		[
		  'name' => 'Paris e Roma - EUR',
		],
		[
		  'name' => 'Paris, Roma e Londres - EUR',
		],
		[
		  'name' => 'Patagônia - Argentina',
		],
		[
		  'name' => 'Patagônia e Buenos Aires - ARG',
		],
		[
		  'name' => 'Penha - SC',
		],
		[
		  'name' => 'Petrópolis - RJ',
		],
		[
		  'name' => 'Piratuba - SC',
		],
		[
		  'name' => 'Porto Alegre - RS',
		],
		[
		  'name' => 'Porto Belo - SC',
		],
		[
		  'name' => 'Porto de Galinhas - PE',
		],
		[
		  'name' => 'Porto de Galinhas e Maragogi',
		],
		[
		  'name' => 'Porto Seguro - BA',
		],
		[
		  'name' => 'Praia da Joaquina - Florianópolis',
		],
		[
		  'name' => 'Praia do Estaleiro - SC',
		],
		[
		  'name' => 'Praia do Francês - AL',
		],
		[
		  'name' => 'Praia do Rosa e Imbituba - SC',
		],
		[
		  'name' => 'Praia do Rosa - SC',
		],
		[
		  'name' => 'Punta Cana',
		],
		[
		  'name' => 'Punta Del Este - URU',
		],
		[
		  'name' => 'Recife - PE',
		],
		[
		  'name' => 'Rio de Janeiro - RJ',
		],
		[
		  'name' => 'Salvador - BA',
		],
		[
		  'name' => 'Santa Cruz do Sul - RS',
		],
		[
		  'name' => 'Santiago do Chile - CHL',
		],
		[
		  'name' => 'Santiago do Chile e Buenos Aires',
		],
		[
		  'name' => 'São Sebastião - SP',
		],
		[
		  'name' => 'Serra Gaúcha - RS',
		],
		[
		  'name' => 'Trancoso - BA',
		],
		[
		  'name' => 'Ubatuba - SP',
		],
		[
		  'name' => 'Urubici - SC',
		],
    ];

    foreach ($destinies as $destiny)
    {
      Destiny::create($destiny);
    }
  }
}
