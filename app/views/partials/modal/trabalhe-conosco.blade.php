<div id="trabalhe-conosco" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-sm modal-stylized">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><span class="entypo users"></span>Trabalhe Conosco</h4>
            </div>
            {{ Former::open_for_files(route('work_with_us.send'))
                ->rules([
                    'trabalheFullName' => 'required|min:5',
                    'trabalheEmail' => 'required|email',
                    'trabalheSexo' => 'required',
                    'trabalhePhone' => 'required|digits_between:10,11',
                    'trabalheCelular' => 'required|digits_between:10,11',
                    'trabalheCEP' => 'required|digits_between:8,8',
                    'trabalheAddress' => 'required',
                    'trabalheAddressBairro' => 'required',
                    'trabalheAddressCity' => 'required',
                    'trabalheAddressState' => 'required',
                    'trabalheAtuacao' => 'required',
                    'trabalheCV' => 'required',
                ])
                ->id('trabalheForm')
                ->name('trabalheForm')
                ->setAttribute('files', true)
            }}
                <div class="modal-body">
                    <p>
                        O INNBatível está sempre à procura de talentos com espírito empreendedor e alto grau de energia. Se você tem esse perfil, então junte-se à nossa equipe e faça parte dessa experiência INNBatível.
                    </p>

                    @include('partials.modal.anti-bot-spam')

                    <div class="form-group">
                        <label class="control-label col-md-4" for="trabalheFullName">Nome completo</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="trabalheFullName" name="trabalheFullName" placeholder="Seu nome completo">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4" for="trabalheEmail">E-mail</label>
                        <div class="col-md-8 input-group">
                            <input type="email" class="form-control" id="trabalheEmail" name="trabalheEmail" placeholder="Seu e-mail">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4" for="trabalheSexo">Sexo</label>
                        <div class="col-md-8">
                            <select class="form-control" id="trabalheSexo" name="trabalheSexo">
                                <option value="" selected="selected">Selecione</option>
                                <option value="Masculino">Masculino</option>
                                <option value="Feminino">Feminino</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4" for="trabalhePhone">Telefone</label>
                        <div class="col-md-8">
                            <input type="text" maxlength="11" class="form-control" id="trabalhePhone" name="trabalhePhone" placeholder="Seu telefone (com DDD)">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4" for="trabalheCelular">Celular</label>
                        <div class="col-md-8">
                            <input type="text" maxlength="11" class="form-control" id="trabalheCelular" name="trabalheCelular" placeholder="Seu celular (com DDD)">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4" for="trabalheCEP">CEP</label>
                        <div class="col-md-8">
                            <input type="text" maxlength="8" class="form-control" id="trabalheCEP" name="trabalheCEP" placeholder="Seu CEP">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4" for="trabalheAddress">Endereço</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="trabalheAddress" name="trabalheAddress" placeholder="Seu endereço (Rua e número)">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4" for="trabalheAddress2">Complemento</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="trabalheAddress2" name="trabalheAddress2" placeholder="Complemento (se houver)">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4" for="trabalheAddressBairro">Bairro</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="trabalheAddressBairro" name="trabalheAddressBairro" placeholder="Seu bairro">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4" for="trabalheAddressCity">Cidade</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="trabalheAddressCity" name="trabalheAddressCity" placeholder="Sua cidade">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4" for="trabalheAddressState">Estado</label>
                        <div class="col-md-8">
                            <select class="form-control" id="trabalheAddressState" name="trabalheAddressState">
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
                        <label class="control-label col-md-4" for="trabalheAtuacao">Atuação</label>
                        <div class="col-md-8">
                            <select class="form-control" id="trabalheAtuacao" name="trabalheAtuacao">
                                <option value="" selected="selected">Selecione</option>
                                <option value="Atendimento">Atendimento ao Cliente</option>
                                <option value="Comercial">Comercial</option>
                                <option value="Marketing">Marketing Digital</option>
                                <option value="Design">Design</option>
                                <option value="TI">TI</option>
                                <option value="Administrativo">Administrativo</option>
                                <option value="Financeiro">Financeiro</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4" for="trabalheCV">Anexar CV</label>
                        <div class="col-md-8">
                            <input type="file" class="form-control" id="trabalheCV" name="trabalheCV" placeholder="Escolha seu CV">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-4 col-md-8">
                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </div>
                    </div>
                </div>
            {{ Former::close() }}
        </div>
    </div>
</div>

<div id="trabalhe-conosco-response" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-sm modal-stylized">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><span class="entypo check"></span>Currículo enviado</h4>
            </div>
            <div class="modal-body">
                <p>
                    <strong>Obrigado por enviar seu CV!</strong>
                </p>
                <p>
                    Assim que houver oportunidades disponíveis em sua área, seu perfil será analisado e entraremos em contato.
                </p>
            </div>
        </div>
    </div>
</div>