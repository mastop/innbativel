<div id="register" class="modal fade" tabindex="-1">
<div class="modal-dialog modal-sm modal-stylized">
<div class="modal-content">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="modal-title"><span class="entypo add-user"></span>Cadastre-se</h4>
</div>
<form id="registerForm" class="form-horizontal" name="registerForm" method="post" action="send_form_register.php" novalidate="novalidate">
<div class="modal-body">
<div class="form-group">
    <div class="col-md-offset-2 col-md-8">
        <a class="img-link" href="https://www.facebook.com/dialog/oauth?client_id=145684162279488&amp;redirect_uri=https%3A%2F%2Finnbativel.com.br%2Flogin-facebook-valida.php&amp;state=c3c19d3dc77284e5e9579f5f317548a9&amp;scope=email%2C+user_birthday%2C+user_hometown"><img src="//innbativel.s3.amazonaws.com/fb-register.png" alt="Faça login com sua conta do Facebook"></a>
    </div>
</div>
<hr>
<div class="form-group">
    <label class="control-label col-md-4" for="registerFullName">Nome completo</label>
    <div class="col-md-8">
        <input type="text" class="form-control" id="registerFullName" name="registerFullName" placeholder="Seu nome completo">
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-4" for="registerEmail">Email</label>
    <div class="col-md-8 input-group">
        <input type="email" class="form-control" id="registerEmail" name="registerEmail" placeholder="Seu email">
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-4" for="registerPhone">Telefone</label>
    <div class="col-md-8">
        <input type="text" maxlength="11" class="form-control" id="registerPhone" name="registerPhone" placeholder="Seu telefone (com DDD)">
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-4" for="registerPassword">Senha</label>
    <div class="col-md-8">
        <input type="password" class="form-control" id="registerPassword" name="registerPassword" placeholder="Escolha uma senha">
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-4" for="registerConfirmPassword">Confirme a senha</label>
    <div class="col-md-8">
        <input type="password" class="form-control" id="registerConfirmPassword" name="registerConfirmPassword" placeholder="Digite novamente a senha">
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-4" for="registerState">Estado</label>
    <div class="col-md-8">
        <select class="form-control" id="registerState" name="registerState">
            <option value="" selected="selected">Selecione</option>
            <option value="AC">Acre</option>
            <option value="AL">Alagoa</option>
            <option value="AM">Amazonas</option>
            <option value="AP">Amapá</option>
            <option value="BA">Bahia</option>
            <option value="CE">Ceará</option>
            <option value="DF">Distrito Federal</option>
            <option value="ES">Espírito Santo</option>
            <option value="GO">Goías</option>
            <option value="MA">Maranhão</option>
            <option value="MG">Minas Gerais</option>
            <option value="MS">Mato Grosso do Sul</option>
            <option value="MT">Mato Grosso</option>
            <option value="PA">Pará</option>
            <option value="PB">Paraíba</option>
            <option value="PE">Pernambuco</option>
            <option value="PI">Piauí</option>
            <option value="PR">Paraná</option>
            <option value="RJ">Rio de Janeiro</option>
            <option value="RN">Rio Grande do Norte</option>
            <option value="RO">Rondônia</option>
            <option value="RR">Roraima</option>
            <option value="RS">Rio Grande do Sul</option>
            <option value="SC">Santa Catarina</option>
            <option value="SE">Sergipe</option>
            <option value="SP">São Paulo</option>
            <option value="TO">Tocantins</option>
        </select>
    </div>
</div>
<div class="form-group">
    <div class="col-md-offset-4 col-md-8">
        <label class="newsletter">
            <input type="checkbox" id="registerNewsletter" name="registerNewsletter" checked="">
            Desejo receber ofertas por email
        </label>
    </div>
</div>
<div class="form-group">
    <div class="panel-group col-md-12" id="eula">
        <div class="panel panel-default">
            <div class="panel-heading text-center">
                <label class="eula">
                    <input type="checkbox" id="registerEULA" name="registerEULA">
                    Li e aceito os <a href="#collapseOne" data-toggle="collapse" data-parent="#eula">termos de uso e a política de privacidade</a>
                </label>
            </div>
            <div id="collapseOne" class="panel-collapse collapse">
                <div id="printEULA" class="panel-body">
                    <!-- <a href="javascript:window.print();" class="control">​Imprimir</a> -->
                    <a href="#" class="control print">​Imprimir</a>
                    <a href="#" target="_blank" class="control">Download</a>
                    <h4>​Termos e Condições de Uso​</h4>​
                    {{ Configuration::get('clauses') }}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="col-md-offset-4 col-md-8">
        <button type="submit" class="btn">Cadastrar</button>
    </div>
</div>
</div>
</form>
<div class="modal-footer">
    Já tem sua conta? <a href="#login" data-toggle="modal" data-dismiss="modal">Faça login</a>
</div>
</div>
</div>
</div>