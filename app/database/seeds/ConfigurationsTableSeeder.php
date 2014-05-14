<?php

class ConfigurationsTableSeeder extends DatabaseSeeder
{
  public function run()
  {
    $configurations = [
      [
        'name' => 'boletus-value', 'value' => '1.6',
      ],
      [
        'name' => 'card-tax-1x', 'value' => '2.66',
      ],
      [
        'name' => 'card-tax-3x', 'value' => '3.41',
      ],
      [
        'name' => 'card-tax-6x', 'value' => '3.66',
      ],
      [
        'name' => 'card-tax-10x', 'value' => '4.16',
      ],
      [
        'name' => 'antecipation-tax-1x', 'value' => '1.49',
      ],
      [
        'name' => 'antecipation-tax-3x', 'value' => '2.98',
      ],
      [
        'name' => 'antecipation-tax-6x', 'value' => '5.215',
      ],
      [
        'name' => 'antecipation-tax-10x', 'value' => '8.195',
      ],
      [
        'name' => 'interest-rate-3x', 'value' => '0.035202404',
      ],
      [
        'name' => 'interest-rate-6x', 'value' => '0.062135342',
      ],
      [
        'name' => 'interest-rate-10x', 'value' => '0.09875344',
      ],
      [
        'name' => 'merchant_id', 'value' => '1234',
      ],
      [
        'name' => 's3access', 'value' => 'AKIAI363KZF7K272NNDQ',
      ],
      [
        'name' => 's3secret', 'value' => '4cOD4MaYbrVQ+A+ftLfvuXXFoslI2NKTt4TbH+IY',
      ],
      [
        'name' => 's3bucket', 'value' => 'innbativel-dev',
      ],
      [
        'name' => 's3region', 'value' => 'sa-east-1',
      ],
      [
        'name' => 's3url', 'value' => 'innbativel-dev.s3.amazonaws.com',
      ],
      [
        'name' => 'popup_time', 'value' => '30',
      ],
      [
        'name' => 'credit', 'value' => '30',
      ],
      [
        'name' => 'braspag_return_url', 'value' => 'http://www.innbativel.com.br/braspag',
      ],
      [
        'name' => 'email', 'value' => 'faleconosco@innbativel.com.br',
      ],
      [
        'name' => 'enable_donations', 'value' => 'true',
      ],
      [
        'name' => 'donation_value', 'value' => '1',
      ],
      [
        'name' => 'enable_comment_moderation', 'value' => 'true',
      ],
      [
        'name' => 'privacy_policy', 'value' => 'PREENCHER DEPOIS DE LANÇAR',
      ],
      [
        'name' => 'clauses', 'value' => '<div>
  Pelo presente instrumento particular, o ASN SERVI&Ccedil;OS DE INFORMA&Ccedil;&Otilde;ES DIGITAIS NA WEB LTDA, doravante designado &ldquo;INNBAT&Iacute;VEL E/OU CONTRATADO&rdquo;, inscrito no CNPJ sob o n&ordm; 12.784.420/0001-15 com sede na Estrada Dom Jo&atilde;o Becker, 145, Ingleses, Florian&oacute;polis, SC, CEP: 88058-600,Tel: 48 33652990, e-mail: faleconosco@innbativel.com.br, e o CONTRATANTE, doravante designado &ldquo;PARCEIRO E/OU CONTRATANTE&rdquo;, celebram um CONTRATO DE PARCERIA, regido pelas cl&aacute;usulas e condi&ccedil;&otilde;es abaixo estabelecidas:</div>
<div>
  &nbsp;</div>
<div>
  <strong>CL&Aacute;USULA PRIMEIRA &ndash; OBJETO</strong></div>
<div>
  &nbsp;</div>
<div>
  1.1 - Por meio deste contrato de parceria, o INNBAT&Iacute;VEL, atrav&eacute;s de seu portal: www.innbativel.com.br e em abas personalizadas em outros sites elegidos por este, vinculado ao seu portal, oferecer&aacute; servi&ccedil;os de hotelaria/passeios/gastronomia ou produtos relacionados ao turismo com descontos a seus consumidores, fornecidos pelo PARCEIRO. Aqueles, por sua vez, acessar&atilde;o o site, escolher&atilde;o o servi&ccedil;o e efetuar&atilde;o o pagamento. Ap&oacute;s a confirma&ccedil;&atilde;o deste, a oferta escolhida poder&aacute; ser utilizada, atrav&eacute;s de cupons dispon&iacute;veis na conta pessoal dos consumidores no portal.</div>
<div>
  1.2 - O limite de cupons, forma de reserva, disponibilidade e detalhes da oferta ser&atilde;o definidos de acordo com o estipulado pelo PARCEIRO.</div>
<div>
  1.3 - O INNBAT&Iacute;VEL disponibilizar&aacute; a oferta do PARCEIRO em at&eacute; 30 (Trinta) dias contados da aceita&ccedil;&atilde;o do presente contrato. A oferta ficar&aacute; no ar em tempo indeterminado, at&eacute; que n&atilde;o haja mais vagas ou quando umas das partes quiser por qualquer motivo, tirar a oferta do ar.</div>
<div>
  1.4 - O INNBAT&Iacute;VEL n&atilde;o assume a obriga&ccedil;&atilde;o de veicular todas as campanhas propostas pelo PARCEIRO em seu portal e as far&aacute; conforme seus exclusivos crit&eacute;rios de estrat&eacute;gia comercial e/ou negocial, sem que isso gere qualquer direito ao PARCEIRO.</div>
<div>
  1.5 - O INNBAT&Iacute;VEL n&atilde;o garante, e, portanto, n&atilde;o poder&aacute; ser responsabilizado qualquer resultado, neg&oacute;cio, expectativa e/ou qualquer outra atividade n&atilde;o concretizada ou n&atilde;o realizada em virtude dos servi&ccedil;os prestados pelo PARCEIRO.</div>
<div>
  1.6 - Cada uma das partes dever&aacute; arcar com as obriga&ccedil;&otilde;es e respectivos encargos civis, fiscais, trabalhistas, tribut&aacute;rios e previdenci&aacute;rios incorridos para o cumprimento das respectivas obriga&ccedil;&otilde;es previstas nesta parceria.</div>
<div>
  1.7 &ndash; O valor de repasse ao INNBAT&Iacute;VEL deve ser confidencial, logo o parceiro n&atilde;o poder&aacute; passar uma tarifa igual ou de menor valor final anunciado no site ao cliente balc&atilde;o.</div>
<div>
  &nbsp;</div>
<div>
  &nbsp;</div>
<div>
  <strong>CL&Aacute;USULA SEGUNDA &ndash; DA REMUNERA&Ccedil;&Atilde;O E DO PAGAMENTO</strong></div>
<div>
  &nbsp;</div>
<div>
  2.1 - O INNBAT&Iacute;VEL ser&aacute; respons&aacute;vel pelo recebimento e divis&atilde;o da receita proveniente desta parceria.</div>
<div>
  2.2 - Os pagamentos ser&atilde;o feitos pelo INNBAT&Iacute;VEL ao PARCEIRO a cada (quinze) dias, a contar a partir do 16&ordf; dia de campanha.</div>
<div>
  &nbsp;</div>
<div>
  &nbsp;2.3- Todos os pagamentos ser&atilde;o realizados mediante transfer&ecirc;ncia banc&aacute;ria, valendo o comprovante da transfer&ecirc;ncia como quita&ccedil;&atilde;o de pagamento.</div>
<div>
  &nbsp;</div>
<div>
  <strong>CL&Aacute;USULA TERCEIRA - RESPONSABILIDADES DAS PARTES</strong></div>
<div>
  &nbsp;</div>
<div>
  3.1 . O INNBAT&Iacute;VEL poder&aacute; efetuar a cobran&ccedil;a do valor pago ao PARCEIRO caso haja cancelamento por parte do cliente por qualquer motivo dentro de 1 (um) ano da data da compra, desde que o cliente n&atilde;o tenha usufru&iacute;do o servi&ccedil;o e o PARCEIRO se obriga a estornar o valor de repasse acordado ao INNBAT&Iacute;VEL.</div>
<div>
  3.2 - Caso o consumidor contate diretamente o INNBAT&Iacute;VEL para reclamar sobre os servi&ccedil;os prestados pelo PARCEIRO, o INNBAT&Iacute;VEL comunicar&aacute; ao PARCEIRO, atrav&eacute;s de correspond&ecirc;ncia eletr&ocirc;nica, que dever&aacute; se manifestar, no prazo de 24h, perante o INNBAT&Iacute;VEL.</div>
<div>
  3.3 - N&atilde;o se manifestando o PARCEIRO nos termos do item anterior, o INNBAT&Iacute;VEL atender&aacute; &agrave; solicita&ccedil;&atilde;o do consumidor, incluindo a possibilidade de lhe conceder a devolu&ccedil;&atilde;o da quantia paga, de acordo com as informa&ccedil;&otilde;es prestadas por eles e o PARCEIRO se obriga a estornar o valor de repasse acordado ao INNBAT&Iacute;VEL.</div>
<div>
  3.4 - O PARCEIRO se responsabiliza integralmente pelos produtos e/ou servi&ccedil;os ofertados perante os consumidores. O INNBAT&Iacute;VEL &eacute; respons&aacute;vel pela veicula&ccedil;&atilde;o da campanha, intermedia&ccedil;&atilde;o da venda, cria&ccedil;&atilde;o, manuten&ccedil;&atilde;o e administra&ccedil;&atilde;o de uma base de usu&aacute;rios cadastrados, interessados nos produtos postos &agrave; venda no seu portal. Cabe ainda &agrave; este, o direito de regresso por eventual descumprimento por parte do PARCEIRO.</div>
<div>
  3.5 - O valor da tarifa determinada pelo PARCEIRO ao INNBAT&Iacute;VEL jamais poder&aacute; ser igual ou superior &agrave; tarifa repassada ao consumidor final e &agrave; concorr&ecirc;ncia.</div>
<div>
  3.6 - Todas as informa&ccedil;&otilde;es a respeito dos usu&aacute;rios dos sites, obtidas em decorr&ecirc;ncia dos servi&ccedil;os, ser&atilde;o de propriedade exclusiva do INNBAT&Iacute;VEL e, como tal, poder&atilde;o ser utilizadas a crit&eacute;rio exclusivo deste, respeitados os limites legais.</div>
<div>
  3.7 - O parceiro assegura ao INNBAT&Iacute;VEL e aos consumidores que os servi&ccedil;os e/ou produtos correspondentes aos cupons emitidos pelo INNBAT&Iacute;VEL durante a vig&ecirc;ncia do presente contrato podem ser fornecidos a qualquer momento, desde que resgatados dentro do per&iacute;odo de validade.</div>
<div>
  &nbsp;</div>
<div>
  &nbsp;</div>
<div>
  <strong>CL&Aacute;USULA QUARTA - VIG&Ecirc;NCIA, RESCIS&Atilde;O E RENOVA&Ccedil;&Atilde;O.</strong></div>
<div>
  4.1 - Este acordo entre em vigor a partir da data de sua assinatura, e permanecer&aacute; v&aacute;lido por prazo indeterminado, podendo ser rescindido sem &ocirc;nus por ambas as partes, mediante aviso pr&eacute;vio m&iacute;nimo de 30(trinta) dias.</div>
<div>
  &nbsp;</div>
<div>
  <strong>CL&Aacute;USULA QUINTA &ndash; DISPOSI&Ccedil;&Otilde;ES FINAIS</strong></div>
<div>
  5.1 - O presente contrato constitui o &uacute;nico e integral acordo entre as Partes com rela&ccedil;&atilde;o ao seu objeto, substituindo e superando quaisquer documentos ou acordos, cartas de inten&ccedil;&atilde;o ou outros instrumentos, celebrados anteriormente a essa data.</div>
<div>
  5.5 - Fica eleito o foro da Comarca da Capital do Estado de Santa Catarina, com exclus&atilde;o de qualquer outro, por mais especial que seja ou se torne, para resolver quaisquer quest&otilde;es decorrentes da presente parceria.</div>',
      ],
    ];

    foreach ($configurations as $configuration)
    {
      Configuration::create($configuration);
    }
  }
}
