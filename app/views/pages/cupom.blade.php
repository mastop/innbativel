<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>INNBatível - Viaje mais por menos</title>
</head>
<body>
<center>
    <br/>
    <input type="button" onclick="javascript: printDiv('printableArea')" value="Imprimir este cupom ou salva-lo como PDF" />
    <br/>
    <br/>
</center>
<div id="printableArea">
    <center>
      <table width="600" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center">&nbsp;</td>
        </tr>
        <tr>
          <td align="center"><table width="500" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="246" align="left"><a href="INNBatível - Viaje mais por menos"><img src="//{{Configuration::get("s3url")}}/logo.png" alt="" width="246" height="68" border="0" style="display:block;"></a></td>
              <td align="right" style="font-size:27px; font-family:Arial, Helvetica, sans-serif; color:#626262;">Cupom</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td align="center">&nbsp;</td>
        </tr>
        <tr>
          <td height="21"><img src="//{{Configuration::get("s3url")}}/linha-separadora.jpg" alt="" width="600" height="21" border="0" style="display:block;"></td>
        </tr>
        <tr>
          <td height="15"></td>
        </tr>
        <tr>
          <td><table border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="398"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td align="center" style="font-size:35px; font-family:Arial, Helvetica, sans-serif; color:#626262;">{{ isset($voucher->offer_partner->offer->destiny)?$voucher->offer_partner->offer->destiny->name:$voucher->offer_partner->offer->title }}</td>
                </tr>
                <tr>
                  <td align="center" style="font-size:23px; font-family:Arial, Helvetica, sans-serif; color:#626262;">{{ $voucher->offer_partner->offer->partner2->full_name }}</td>
                </tr>
                <tr>
                  <td align="center" style="font-size:15px; font-family:Arial, Helvetica, sans-serif; color:#626262;">{{ $voucher->offer_partner->offer->partner2->full_address }}</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td align="center" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; color:#626262;">Código</td>
                </tr>
                <tr>
                  <td align="center" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; color:#626262; font-weight:bold;">{{ $voucher->id }}-{{ $voucher->display_code }}</td>
                </tr>
                <tr>
                  <td align="center" style="font-size:15px; font-family:Arial, Helvetica, sans-serif; color:#626262;">{{ $voucher->offer_partner->title }}</td>
                </tr>
              </table></td>
              <td width="7" align="center"><img src="//{{Configuration::get("s3url")}}/linha-separadora-vertical.jpg" alt="" width="7" height="202" style="display:block;" border="0"></td>
              <td width="195"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td align="center" style="font-size:17px; font-family:Arial, Helvetica, sans-serif; color:#626262; font-weight:bold;">Nome </td>
                </tr>
                <tr>
                  <td align="center" style="font-size:20px; font-family:Arial, Helvetica, sans-serif; color:#626262; font-style:italic;">{{ isset($voucher->order_buyer->buyer->profile)?$voucher->order_buyer->buyer->full_name:'' }}</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td align="center" style="font-size:17px; font-family:Arial, Helvetica, sans-serif; color:#626262; font-weight:bold; ">Valor</td>
                </tr>
                <tr>
                  <td align="center" style="font-size:20px; font-family:Arial, Helvetica, sans-serif; color:#626262; font-style:italic;">R$ {{ number_format($voucher->offer_partner->price_with_discount,'0',',','.') }}</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td align="center" style="font-size:17px; font-family:Arial, Helvetica, sans-serif; color:#626262; font-weight:bold;">Validade</td>
                </tr>
                <tr>
                  <td align="center" style="font-size:21px; font-family:Arial, Helvetica, sans-serif; color:#626262; font-style:italic;">{{ $voucher->offer_partner->voucher_validity_end }}</td>
                </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="15"></td>
        </tr>
        <tr>
          <td height="21"><img src="//{{Configuration::get("s3url")}}/linha-separadora.jpg" alt="" width="600" height="21" border="0" style="display:block;"></td>
        </tr>
        <tr>
          <td height="10"></td>
        </tr>
        <tr>
          <td align="left" style="font-size:14px; font-family:Arial, Helvetica, sans-serif; color:#626262; font-weight:bold; font-style:italic;">Destaques:</td>
        </tr>
        <tr>
          <td height="10"></td>
        </tr>
        <tr>
          <td align="left" style="font-size:13px; font-family:Arial, Helvetica, sans-serif; color:#626262; line-height:1.6em; text-align:justify;">{{ $voucher->offer_partner->offer->features }}</td>
        </tr>
        <tr>
          <td height="10"></td>
        </tr>
        <tr>
          <td align="left" style="font-size:14px; font-family:Arial, Helvetica, sans-serif; color:#626262; font-weight:bold; font-style:italic;">Política de Reagendamento/Cancelamento:</td>
        </tr>
        <tr>
          <td height="10"></td>
        </tr>
        <tr>
          <td align="left" style="font-size:13px; font-family:Arial, Helvetica, sans-serif; color:#626262; line-height:1.6em; text-align:justify;">{{ $voucher->offer_partner->offer->rules }}</td>
        </tr>
        <tr>
          <td height="10"></td>
        </tr>
        <tr>
          <td height="21"><img src="//{{Configuration::get("s3url")}}/linha-separadora.jpg" alt="" width="600" height="21" border="0" style="display:block;"></td>
        </tr>
        <tr>
          <td height="45" align="center" style="font-size:14px; font-family:Arial, Helvetica, sans-serif; color:#626262; font-weight:bold; font-style:italic;">Qualquer dúvida ou comentário, por favor entre em contato através do e-mail<br>
          faleconosco@innbativel.com.br</td>
        </tr>
        <tr>
          <td height="21"><img src="//{{Configuration::get("s3url")}}/linha-separadora.jpg" alt="" width="600" height="21" border="0" style="display:block;"></td>
        </tr>
        <tr>
          <td align="right" style="font-size:13px; font-family:Arial, Helvetica, sans-serif; color:#626262; font-weight:bold;">Imprima este cupom e apresente no estabelecimento!</td>
        </tr>
      </table>
    </center>
</div>
<script>
    function printDiv(divName) {
       var printContents = document.getElementById(divName).innerHTML;
       var originalContents = document.body.innerHTML;

       document.body.innerHTML = printContents;

       window.print();

       document.body.innerHTML = originalContents;
    }
</script>
</body>
</html>