<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>INNBatível - Viaje mais por menos</title>
<style type="text/css">
a, a:link, a:visited, a:hover, a:focus, a:active{
  color:#fff;
}
</style>
</head>
<body>
<center>
    <table width="600" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center"><img src="https://{{Configuration::get("s3url")}}/casal.jpg" width="600" height="354" alt="" style="display:block;"></td>
      </tr>
      <tr>
        <td align="center" bgcolor="#4060a6"><table width="550" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align="left" style="font-size:30px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#f0cf31; font-style:italic;">{{ $name }}</td>
          </tr>
          <tr>
            <td align="left" style="font-family:Arial, Helvetica, sans-serif; font-size:15px; font-weight:bold; color:#FFF;">Foi efetuado um pagamento da INNBatível para você, referente ao período de vendas no site INNBatível de {{ $sales_from }} até {{ $sales_to }}, num total de R${{ $total }}</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align="left" style="font-family:Arial, Helvetica, sans-serif; font-size:17px; color:#FFF;">Veja mais detalhes no <a href="{{ $url }}">painel do parceiro INNBatível</a>.</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table>
</center>
</body>
</html>
