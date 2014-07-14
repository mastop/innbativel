<div id="contact" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-sm modal-stylized">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><span class="entypo chat"></span>Fale conosco</h4>
            </div>
            {{ Former::horizontal_open(route('contact.send'))
                ->rules([
                    'contactName' => 'required', 'contactEmail' => 'required','contactMessage' => 'required'
                ])
                ->id('contactForm')
                ->name('contactForm')
            }}
                <div class="modal-body">
                    <p>
                        Envie sua mensagem preenchendo os campos abaixo.<br>
                        Muito em breve vamos entrar em contato com você.
                    </p>
                    <div class="form-group">
                        <label class="control-label col-md-4" for="contactName">Nome</label>
                        <div class="col-md-8 input-group">
                            {{ Former::text('contactName')->label('')->class('form-control')->placeholder('Seu nome')->autofocus(); }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4" for="contactEmail">Email</label>
                        <div class="col-md-8 input-group">
                            {{ Former::email('contactEmail')->label('')->class('form-control')->placeholder('Seu email')->value(Auth::check()?Auth::user()->email:''); }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4" for="contactPhone">Telefone</label>
                        <div class="col-md-8">
                            {{ Former::text('contactPhone')->label('')->maxlength(11)->class('form-control')->placeholder('Seu telefone (com DDD)'); }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4" for="contactCelular">Celular</label>
                        <div class="col-md-8">
                            {{ Former::text('contactCelular')->label('')->maxlength(11)->class('form-control')->placeholder('Seu celular (com DDD)'); }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4" for="contactMessage">Sua mensagem</label>
                        <div class="col-md-8">
                            {{ Former::textarea('contactMessage')->label('')->class('form-control')
                                ->placeholder('Digite suas dúvidas, sugestões ou críticas')
                                ->rows(10)->columns(20); }}
                        </div>

                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-4 col-md-8">
                            <input type="hidden" name="url" value="{{ Request::url() }}"/>
                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </div>
                    </div>
                </div>
            {{ Former::close() }}
        </div>
    </div>
</div>

<div id="contactResponse" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-sm modal-stylized">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><span class="entypo check"></span>Mensagem enviada</h4>
            </div>
            <div class="modal-body">
                <p>
                    <strong>Obrigado por entrar em contato!</strong>
                </p>
                <p>
                    Sua mensagem é muito importante para nós.
                </p>
            </div>
        </div>
    </div>
</div>