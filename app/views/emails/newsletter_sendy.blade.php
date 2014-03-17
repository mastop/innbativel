<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>InnBativel - Viaje mais por menos</title>
</head>
<body>
<center>
<table width="630" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="15">&nbsp;</td>
    <td width="600">
        <table width="600" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="600" height="20" align="center" style="font-size:10px;font-family:Arial;color:#555"><webversion>Visualize esta mensagem no navegador</webversion>.</td>
          </tr>
          <tr>
            <td width="600" height="20" align="center">&nbsp;</td>
          </tr>
          <tr>
            <td width="600" align="center"><a href="http://www.innbativel.com.br" title="InnBatível - Viaje mais por menos" target="_blank"><img src="http://www.innbativel.com.br/img/newsletters/novasofertas/logo-innbativel.jpg" alt="InnBatível - Viaje mais por menos - Logotipo para newsletter" width="207" height="56" border="0"></a></td>
          </tr>
          <tr>
            <td width="600" height="20">&nbsp;</td>
          </tr>
          <tr>
            <td width="600">&nbsp;</td>
          </tr>
          @foreach($offers as $offer)
            <tr>
              <td width="600" align="left" style="font-size:19px; font-style:italic; font-family:Arial, Helvetica, sans-serif; color:#8c8b89; padding:0 5px;"><a href="{{ $offer->slug }}" title="" target="_blank" style="font-size:19px; font-style:italic; font-family:Arial, Helvetica, sans-serif; color:#8c8b89; text-decoration:none;">{{ $offer->title }}</a></td>
            </tr>
            <tr>
              <td width="600" height="10"></td>
            </tr>
            <tr>
              <td><a href="{{ $offer->slug }}" title=""><img src="{{ $offer->newsletter_img }}" alt="Oferta no INNBatível - Viaje mais, por menos" width="600" height="220" border="0" style="display:block"></a></td>
            </tr>
            <tr>
              <td height="12"><img src="http://www.innbativel.com.br/img/newsletters/novasofertas/sombra-fotos.jpg" width="600" height="12" alt="" style="display:block;"></td>
            </tr>
            <tr>
              <td align="center"><table width="586" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="10"><img src="http://www.innbativel.com.br/img/newsletters/novasofertas/esquerda-texto.jpg" width="10" height="42" alt="" style="display:block;"></td>
                  <td width="435" align="center" bgcolor="#2860aa"><table border="0" cellspacing="4" cellpadding="0">
                    <tr>
                      <td align="left" valign="middle" style="font-size:14px; font-family:Arial, Helvetica, sans-serif; color:#f0cf31; font-weight:700;text-decoration:line-through;"><s>de</s></td>
                      <td align="left" valign="middle" style="font-size:20px; font-family:Arial, Helvetica, sans-serif; color:#f0cf31; font-weight:700; text-decoration:line-through;"><s>R$ {{ number_format($offer->price_original, '0', ',', '.') }}</s></td>
                      <td width="15" align="left" valign="middle">&nbsp;</td>
                      <td align="left" valign="middle" style="font-size:15px; font-family:Arial, Helvetica, sans-serif; color:#f0cf31; font-weight:700;">por</td>
                      <td align="left" valign="middle" style="font-size:26px; font-family:Arial, Helvetica, sans-serif; color:#f0cf31; font-weight:700;">R$ {{ number_format($offer->price_with_discount, '0', ',', '.') }}</td>
                      <td width="30" align="left" valign="middle">&nbsp;</td>
                      <td align="left" valign="middle" style="font-size:14px; font-family:Arial, Helvetica, sans-serif; color:#e5e5e5; font-style:italic; font-weight:700;">desconto:</td>
                      <td align="left" valign="middle" style="font-size:23px; font-family:Arial, Helvetica, sans-serif; color:#e5e5e5; font-weight:700;">{{ $offer->installment }}%</td>
                      </tr>
                  </table></td>
                  <td width="10"><img src="http://www.innbativel.com.br/img/newsletters/novasofertas/direita-texto.jpg" width="10" height="42" alt="" style="display:block;"></td>
                  <td width="15">&nbsp;</td>
                  <td width="126"><a href="{{ $offer->slug }}" title="Confira"><img src="http://www.innbativel.com.br/img/newsletters/novasofertas/botao-confira.jpg" alt="Botão confira esta oferta INNBatível" width="126" height="42" border="0" style="display:block;"></a></td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td height="30">&nbsp;</td>
            </tr>
            <tr>
              <td width="600" height="1"><img src="http://www.innbativel.com.br/img/newsletters/novasofertas/separador.jpg" width="600" height="1" alt="" style="display:block;"></td>
            </tr>
            <tr>
              <td height="30">&nbsp;</td>
            </tr>
          @endforeach
          <tr>
          	<td height="12"><img src="http://www.innbativel.com.br/img/newsletters/novasofertas/linha-rodape.jpg" width="600" height="12" alt="" style="display:block;"></td>
          </tr>
          <tr>
            <td height="55" align="right" valign="middle" bgcolor="#2860aa"><table width="215" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="85"><img src="http://www.innbativel.com.br/img/newsletters/novasofertas/texto-rodape.jpg" alt="Siga-nos" width="85" height="27" border="0" style="display:block;"></td>
                <td width="28"><a href="https://www.facebook.com/innbativel" title="Facebook" target="_blank"><img src="http://www.innbativel.com.br/img/newsletters/novasofertas/facebook.jpg" alt="Facebook" width="28" height="27" border="0" style="display:block;"></a></td>
                <td width="29"><a href="https://twitter.com/innbativel" title="Twitter" target="_blank"><img src="http://www.innbativel.com.br/img/newsletters/novasofertas/twitter.jpg" alt="Twitter" width="29" height="27" border="0" style="display:block;"></a></td>
                <td width="29"><a href="http://pinterest.com/innbativel/" title="Pinterest" target="_blank"><img src="http://www.innbativel.com.br/img/newsletters/novasofertas/pinterest.jpg" alt="Pinterest" width="29" height="27" border="0" style="display:block;"></a></td>
                <td width="29"><a href="https://plus.google.com/113905450286255764962" title="Google+" target="_blank"><img src="http://www.innbativel.com.br/img/newsletters/novasofertas/google.jpg" alt="Google+" width="29" height="27" border="0" style="display:block;"></a></td>
                <td width="15">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td height="20" align="center" style="font-size:10px;font-family:Arial;color:#555">Caso não deseje mais participar de nossa newsletter, <unsubscribe>cancele seu recebimento</unsubscribe>.</td>
          </tr>
        </table>
    </td>
    <td width="15">&nbsp;</td>
  </tr>
</table>
</center>
</body>
</html>
