<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>INNBatível - Viaje mais por menos</title>

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
    @if($data['system'] == 'sendy')
    <webversion>Visualize esta mensagem no navegador</webversion>
    @else
    <a href="[[view_this_message]]">Visualize esta mensagem no navegador</a>
    @endif
</div>

<table cellpadding="0" cellspacing="0" border="0" bgcolor="#F2F2F2" width="600" align="center">
    <tr>
        <td style="padding:10px 0 10px; text-align:center">
            <a href="{{route('home')}}" target="_blank" title="INNBatível - viaje mais por menos"><img src="https://{{Configuration::get('s3bucket')}}.s3.amazonaws.com/logo.png" width="200" height="54" alt="INNBatível - viaje mais por menos" border="0" /></a>
        </td>
    </tr>
</table>

<table cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" width="600" align="center" style="border: 1px solid #FFC4A1;">
    <tr>
        <td width="120" style="text-align:center; border-right: 1px dashed #FFCFB3; padding: 20px 0;"><a href="{{url('/hoteis-e-pousadas')}}" target="_blank" title="Hot&eacute;is &amp; Pousadas" style="color:#004286; text-decoration:none; font-size:14px; display:inline-block;">Hot&eacute;is &amp;<br>Pousadas</a></td>
        <td width="120" style="text-align:center; border-right: 1px dashed #FFCFB3; padding: 20px 0;"><a href="{{url('/pacotes-nacionais')}}" style="color:#004286; text-decoration:none; font-size:14px;">Pacotes<br />Nacionais</a></td>
        <td width="120" style="text-align:center; border-right: 1px dashed #FFCFB3; padding: 20px 0;"><a href="{{url('/pacotes-internacionais')}}" style="color:#004286; text-decoration:none; font-size:14px;">Pacotes<br />Internacionais</a></td>
        <td width="120" style="text-align:center; border-right: 1px dashed #FFCFB3; padding: 20px 0;"><a href="{{url('/feriados')}}" class="single-line" style="color:#004286; text-decoration:none; font-size:14px;"><span>Feriados</span></a></td>
        <td width="120" style="text-align:center"><a href="{{url('/passeios')}}" style="color:#004286; text-decoration:none; font-size:14px;">Passeios &amp;<br />Gastronomia</a></td>
    </tr>
</table>

@if($data['banner']['img'])
<table cellpadding="0" cellspacing="0" border="0" width="600" align="center" style="margin-top:13px;">
    <tr>
        <td bgcolor="#e5e5e5" width="600" style="border:1px solid #FFC4A1">
            <a href="{{$data['banner']['link']}}"><img src="{{$data['banner']['img']}}" width="600" alt="INNBatível - viaje mais por menos" style="display:block;" border="0" /></a>
        </td>
    </tr>
</table>
@endif
@foreach($data['group'] as $k => $v)
<table cellpadding="0" cellspacing="0" border="0" width="600" align="center" style="margin-top:13px; border:1px solid #D1CECE;background: #e5e5e5;">
    <tr>
        <td bgcolor="#e5e5e5" width="600" style="color:#004286; font-size:20px; padding:13px;">
            {{$v['title']}}
        </td>
    </tr>
    <tr>
        <td>
            <table cellpadding="0" cellspacing="0" border="0" width="600" align="center">
                <tr>
                    @foreach($v['offer'] as $i => $offer)
                    <td width="13">&nbsp;</td>
                    <td bgcolor="#ffffff" width="280" style="border: 1px solid #FFC4A1;">
                        <a href="{{$offer->url}}" target="_blank" title="{{$offer->short_title}}" style="text-decoration:none;">
                            <img src="https:{{$offer->newsletter_img}}" width="280" height="117" alt="{{$offer->destiny->name}}" style="display:block;" border="0" />
                            <h2 style="padding:0px 10px 0px 15px; color:#45454c; font-size:16px; font-weight:500">{{$offer->destiny->name}}</h2>
                            <p style="padding:0px 10px 0px 15px; color:#737480; font-size:13px; font-weight:400">
                                @foreach ($offer->included as $in => $included)
                                {{ $included->title }}
                                @if(count($offer->included) < $in), @endif
                                @endforeach
                            </p>
                            <p style="display:inline-block; padding:10px 10px 15px 15px; color:#737480; font-size:13px; font-weight:400">
                                De <span style="text-decoration:line-through;">R${{intval($offer->price_original)}}</span><strong style="display:block; color: #FF7F33; font-size: 17px; font-weight:500">
                                    Por R$<span style="font-size: 24px; padding-left:2px; font-weight:800">{{intval($offer->price_with_discount)}}</span></strong>
                            </p>
                            <p style="display:inline-block; padding:10px 10px 15px 15px; color:#737480; font-size:12px; font-weight:400; line-height:1">
                                <span style="display:block; font-size: 16px; font-weight:500"><strong style="font-size: 24px; font-weight:500">{{intval($offer->percent_off)}}</strong>%</span>
                                <span style="display:block; font-size: 16px; font-weight:500; letter-spacing:2px;">OFF</span>
                            </p>
                            <p style="display:inline-block; padding:10px 10px 15px 15px; color:#737480; font-size:12px; font-weight:400">
                                Em até <strong style="display:block; font-size: 24px; font-weight:500">10x</strong>
                            </p>
                        </a>
                    </td>
                    @if($i % 2 != 0)
                        <td width="13">&nbsp;</td>
                        </tr>
                        <tr>
                            <td height="13">&nbsp;</td>
                        </tr>
                        @if(count($v['offer']) -1 > $i)
                            <tr>
                        @endif
                    @endif
                    @endforeach
            </table>
        </td>
    </tr>
    @if($v['link_text'])
    <tr>
        <td bgcolor="#e5e5e5" width="600" style="padding:13px">
            <a href="{{$v['link']}}" style="color:#fff; background:#FF7F33; text-decoration:none; padding:10px; border:1px dashed #FFCFB3; display:inline-block; font-size:14px">Veja mais ofertas de <strong>{{$v['link_text']}}</strong></a>
        </td>
    </tr>
    @endif
</table>
@endforeach
<div style="text-align:center; color: #666666; padding:15px 0">
@if($data['system'] == 'sendy')
Caso não deseje mais participar de nossa newsletter, <unsubscribe>cancele seu recebimento</unsubscribe>
@endif
</div>

</div>

</body>
</html>