<div id="login" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-sm modal-stylized">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><span class="entypo login"></span>Entre em sua conta</h4>
            </div>
            <form id="loginForm" class="form-horizontal" name="loginForm" method="post" action="{{ route('login.post') }}" novalidate="novalidate">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <a class="img-link" href="{{ route('facebook', array('destination' => e(Input::get('destination', Request::getPathInfo())))) }}"><img src="//innbativel.s3.amazonaws.com/fb-login.png" alt="Faça login com sua conta do Facebook"></a>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label class="control-label col-md-2" for="loginEmail">Email</label>
                        <div class="col-md-8 input-group">
                            <!-- <span class="input-group-addon">@</span> -->
                            <input type="email" class="form-control" id="loginEmail" name="email" placeholder="Seu email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2" for="loginPassword">Senha</label>
                        <div class="col-md-8">
                            <input type="password" class="form-control" id="loginPassword" name="password" placeholder="Sua senha">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                            <input type="hidden" name="destination" value="{{{ Input::get('destination', Request::path()) }}}"/>
                            <button type="submit" class="btn">Entrar</button>
                            <a href="#pass-recover" class="pass-recover" data-toggle="modal" data-dismiss="modal">Esqueci minha senha</a>
                        </div>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                Ainda não tem uma conta? <a href="#register" data-toggle="modal" data-dismiss="modal">Cadastre-se agora</a>
            </div>
        </div>
    </div>
</div>
@if(Input::get('destination'))
<script>
    $('#login').modal('show');
</script>
@endif