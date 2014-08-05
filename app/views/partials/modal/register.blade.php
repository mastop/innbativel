<div id="register" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-sm modal-stylized">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><span class="entypo add-user"></span>Cadastre-se</h4>
            </div>
            {{ Former::framework('Nude') }}
            {{ Former::horizontal_open(route('account.create'))->rules([
            'registerEmail' => 'required|email',
            'registerFullName' => 'required',
            'registerPhone' => 'required|numeric',
            'registerPassword'      => 'required|min:6|confirmed',
            'registerPassword_confirmation' => 'required|min:6',
            ])->id('registerForm')->name('registerForm')->novalidate('novalidate')->class('form-horizontal') }}
            <div class="modal-body">
            <div class="form-group">
                <div class="col-md-offset-2 col-md-8">
                    <a class="img-link" href="{{ route('login.facebook', array('destination' => Input::get('destination', Request::getPathInfo()))) }}"><img src="//{{Configuration::get("s3url")}}/fb-register.png" alt="Faça login com sua conta do Facebook"></a>
                </div>
            </div>
            <hr>
            <div class="form-group">
                <label class="control-label col-md-4" for="registerFullName">Nome completo</label>
                <div class="col-md-8">
                    {{ Former::text('registerFullName')->class('form-control')->placeholder('Seu nome completo') }}
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4" for="registerEmail">Email</label>
                <div class="col-md-8 input-group">
                    {{ Former::email('registerEmail')->class('form-control')->placeholder('Seu email') }}
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4" for="registerPhone">Telefone</label>
                <div class="col-md-8">
                    {{ Former::text('registerPhone')->class('form-control')->placeholder('Seu telefone (com DDD)')->maxlength(11) }}
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4" for="registerPassword">Senha</label>
                <div class="col-md-8">
                    {{ Former::password('registerPassword')->class('form-control')->placeholder('Escolha uma senha') }}
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4" for="registerConfirmPassword">Confirme a senha</label>
                <div class="col-md-8">
                    {{ Former::password('registerPassword_confirmation')->class('form-control')->placeholder('Digite novamente a senha') }}
                </div>
            </div>
            <!--
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
            -->
            <div class="form-group">
                <div class="col-md-offset-4 col-md-8">
                    <label class="newsletter">
                        {{ Former::checkbox('registerNewsletter')
                        ->check() }}
                        Desejo receber ofertas por email
                    </label>
                </div>
            </div>
            <div class="form-group">
                <div class="panel-group col-md-12" id="eula">
                    <div class="panel panel-default">
                        <div class="panel-heading text-center">
                            <label class="eula">
                                {{ Former::checkbox('registerEULA') }}
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
                     {{ Former::actions()
                     ->btn_submit('Cadastrar') }}
                 </div>
             </div>
             </div>
            <input type="hidden" name="destination" value="{{{ Input::get('destination', Request::path()) }}}"/>
            <input type="hidden" name="modal" value="register"/>
             {{Former::close()}}
             <div class="modal-footer">
                 Já tem sua conta? <a href="#login" data-toggle="modal" data-dismiss="modal">Faça login</a>
             </div>
         </div>
     </div>
</div>
