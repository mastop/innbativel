
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>{{ $send['title'] }}</title>
		 
	<style type="text/css">
		.ExternalClass {width:100%;} 

		.ExternalClass,
		.ExternalClass p,
		.ExternalClass span,
		.ExternalClass font,
		.ExternalClass td,
		.ExternalClass div {
			line-height: 100%;
		}

		body {-webkit-text-size-adjust:none; -ms-text-size-adjust:none;}

		body {margin:0; padding:0;}

		table td {border-collapse:collapse;}

		p {margin:0; padding:0; margin-bottom:0;}

		h1,
		h2,
		h3,
		h4,
		h5,
		h6 {
			color: black; 
			line-height: 100%;
		}

		a,
		a:link {
			color:#2A5DB0;
			text-decoration: underline;
		}

		body, #body_style {
			background:#F2F2F2;
			min-height:1000px;
			color:#fff;
			font-family:Arial, Helvetica, sans-serif;
			font-size:12px;
		}
		 
		span.yshortcuts { color:#000; background-color:none; border:none;}
		span.yshortcuts:hover,
		span.yshortcuts:active,
		span.yshortcuts:focus {color:#000; background-color:none; border:none;}

		a:visited { color: #3c96e2; text-decoration: none}
		a:focus   { color: #3c96e2; text-decoration: underline}
		a:hover   { color: #3c96e2; text-decoration: underline}
			 
		@media only screen and (max-device-width: 480px) {
			body[yahoo] #container1 {display:block !important}  
			body[yahoo] p {font-size: 10px} 
		}       
		 
		@media only screen and (min-device-width: 768px) and (max-device-width: 1024px)  {
			body[yahoo] #container1 {display:block !important} 
			body[yahoo] p {font-size: 12px}
		}
	</style>
</head>

<body style="background:#F2F2F2; min-height:1000px; color:#fff;font-family:Arial, Helvetica, sans-serif; font-size:12px"
alink="#FF0000" link="#FF0000" bgcolor="#000000" text="#FFFFFF" yahoo="fix"> 
 
		<div id="body_style">
			<div style="text-align:center; color: #666666; padding:15px 0">
				<a href="#">Visualize esta mensagem no navegador</a>.
			</div>

			<table cellpadding="0" cellspacing="0" border="0" bgcolor="#F2F2F2" width="600" align="center">
				<tr>
					<td style="padding:10px 0 10px; text-align:center">
						<a href="https://innbativel.com.br" target="_blank" title="INNBatível - viaje mais por menos"><img src="logo.png" width="200" height="54" alt="INNBatível - viaje mais por menos" border="0" /></a>
					</td>
				</tr>
			</table>

			<table cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" width="600" align="center" style="border: 1px solid #FFC4A1;">
				<tr>
					<td width="120" style="text-align:center; border-right: 1px dashed #FFCFB3; padding: 20px 0;"><a href="https://innbativel.com.br/hoteis-pousadas.html" target="_blank" title="Hot&eacute;is &amp; Pousadas" style="color:#004286; text-decoration:none; font-size:14px; display:inline-block;">Hot&eacute;is &amp;<br>Pousadas</a></td>
					<td width="120" style="text-align:center; border-right: 1px dashed #FFCFB3; padding: 20px 0;"><a href="https://innbativel.com.br/pacotes-nacionais.html" style="color:#004286; text-decoration:none; font-size:14px;">Pacotes<br />Nacionais</a></td>
					<td width="120" style="text-align:center; border-right: 1px dashed #FFCFB3; padding: 20px 0;"><a href="https://innbativel.com.br/pacotes-internacionais.html" style="color:#004286; text-decoration:none; font-size:14px;">Pacotes<br />Internacionais</a></td>
					<td width="120" style="text-align:center; border-right: 1px dashed #FFCFB3; padding: 20px 0;"><a href="https://innbativel.com.br/feriados.html" class="single-line" style="color:#004286; text-decoration:none; font-size:14px;"><span>Feriados</span></a></td>
					<td width="120" style="text-align:center"><a href="https://innbativel.com.br/passeios-gastronomia.html" style="color:#004286; text-decoration:none; font-size:14px;">Passeios &amp;<br />Gastronomia</a></td>
				</tr>
			</table>

<?php $cont = 0;?>
@foreach($send['offers'] as $offers)
    @if(count($offers)>0)
            <?php $cont++;?>
            <table cellpadding="0" cellspacing="0" border="0" width="600" align="center" style="margin-top:13px; border:1px solid #D1CECE;background: #e5e5e5;">
				<tr>
					<td bgcolor="#e5e5e5" width="600" style="color:#004286; font-size:20px; padding:13px;">
                        {{$send['input'][$cont]}}
					</td>
				</tr>
				<tr>
					<td>
						<table cellpadding="0" cellspacing="0" border="0" width="600" align="center">
							<tr>
								<td width="13">&nbsp;</td>
                                <?php $n = 0; ?>
                                @foreach($offers as $offer)
                                <?php $n++; ?>
<!------------------------------inicio pular linha quando passar duas ofertas-------------------------------->
                                @if($n==3)
                            </tr>
                        </table>
                        <table cellpadding="0" cellspacing="0" border="0" width="600" align="center">
                            <tr>
                                <td width="13">&nbsp;</td>
                                <?php $n = 1; ?>
                                @endif
<!------------------------------fim pular linha quando passar duas ofertas----------------------------------->
								<td bgcolor="#ffffff" width="280" style="border: 1px solid #FFC4A1;">
                                    <a href="{{ $offer->slug }}" target="_blank" title="INNBatível - viaje mais por menos"
                                       style="text-decoration:none;">
                                        <img src="{{ $offer->cover_img }}" width="280" height="117"
                                             alt="{{ $offer->descricao }}" style="display:block;" border="0"/>
										<h2 style="padding:0px 10px 0px 15px; color:#45454c; font-size:16px; font-weight:500">{{ $offer->title }}</h2>
										<p style="padding:0px 10px 0px 15px; color:#737480; font-size:13px; font-weight:400">
                                            {{ $offer->subtitle }}
										</p>
                                        <p style="display:inline-block; padding:10px 10px 15px 15px; color:#737480; font-size:13px; font-weight:400">
                                            De <span style="text-decoration:line-through;">R$ {{ number_format($offer->price_original, '0', ',', '.') }}</span><strong
                                                style="display:block; color: #FF7F33; font-size: 17px; font-weight:500">
                                                Por R$<span style="font-size: 24px; padding-left:2px; font-weight:800">R$ {{ number_format($offer->price_with_discount, '0', ',', '.') }}</span></strong>
                                        </p>
                                        <p style="display:inline-block; padding:10px 10px 15px 15px; color:#737480; font-size:12px; font-weight:400; line-height:1">
                                            <span style="display:block; font-size: 16px; font-weight:500">
                                                <strong style="font-size: 24px; font-weight:500">{{
                                                            number_format($offer->percent_off,
                                                        '0', ',', '.') }}%
                                                </strong>%
                                            </span>
                                            <span style="display:block; font-size: 16px; font-weight:500; letter-spacing:2px;">OFF</span>
                                        </p>

                                        <p style="display:inline-block; padding:10px 10px 15px 15px; color:#737480; font-size:12px; font-weight:400">
                                            Em até <strong style="display:block; font-size: 24px; font-weight:500">{{
                                                number_format($offer->min_qty, '0', ',', '.') }}x</strong>
                                        </p>
									</a>
								</td>
								<td width="13">&nbsp;</td>
                                @endforeach
                                @if($n==1)
                                <td width="280"">&nbsp;</td>
                                <td width="13">&nbsp;</td>
                                @endif
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td bgcolor="#e5e5e5" width="600" style="padding:13px">
						<a href="{{$send['button'][$cont]}}" style="color:#fff; background:#FF7F33;
						    text-decoration:none; padding:10px; border:1px dashed #FFCFB3; display:inline-block;
						    font-size:14px">
                            {{$send['text'][$cont]}}
                        </a>
					</td>
				</tr>
			</table>
    @endif
@endforeach

			<div style="text-align:center; color: #666666; padding:15px 0">
				Caso não deseje mais receber nossas ofertas por email, você pode <a href="#">cancelar seu recebimento</a>.
			</div>
				 
		</div> 
 
</body>
</html>