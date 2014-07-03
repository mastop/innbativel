<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width"/>
    <style type="text/css">{{ File::get(public_path() . '/assets/vendor/ink/ink.css') }}</style>
    <style type="text/css">
    	html, body { background: #f5f5f5; }
    	h2 { display: block;  }
    	.container { border: 1px solid #eee; background: #fff; }
    	.inner { margin: 30px; }
    </style>
  </head>
  <body>
    <table class="body"><tr><td class="center" align="center" valign="top"><center><table class="container"><tr><td><div class="inner">

		<h2 class="title">Redefina sua Senha</h2>
		<p>Clique <a href="{{ URL::to('recuperar/senha', $token) }}" target="_blank">aqui</a> para alterar sua senha de acesso.</p>

    </div></td></tr></table></center></td></tr></table>
  </body>
</html>