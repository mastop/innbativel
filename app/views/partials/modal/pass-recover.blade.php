<div id="pass-recover" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-sm modal-stylized">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><span class="entypo flashlight"></span>Esqueceu sua senha?</h4>
            </div>
            <form id="passRecoverForm" class="form-horizontal" name="passRecoverForm" method="post" action="{{route('password.request')}}" novalidate="novalidate">
                <div class="modal-body">
                    <p>
                        Digite seu email cadastrado para recuperar sua senha.<br>
                    </p>
                    <div class="form-group">
                        <label class="control-label col-md-3" for="passRecoverEmail">Seu email</label>
                        <div class="col-md-8 input-group">
                            <input type="email" class="form-control" id="passRecoverEmail" name="passRecoverEmail" placeholder="Seu email cadastrado">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-3 col-md-8">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                            <button type="submit" class="btn">Recuperar senha</button>
                            <a href="#login" class="login" data-toggle="modal" data-dismiss="modal">Voltar</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="passRecoverResponse" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-sm modal-stylized">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><span class="entypo check"></span>Solicitação enviada</h4>
            </div>
            <div class="modal-body">
                <p>
                    Enviamos um link para mudança de sua senha por email.
                </p>
                <p>
                    Por favor, acesse sua conta de email e siga as instruções enviadas.
                </p>
            </div>
        </div>
    </div>
</div>