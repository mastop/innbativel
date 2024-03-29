<div id="newsletter" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-sm modal-stylized">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><span class="entypo mail"></span>Receba ofertas por E-mail</h4>
            </div>
            {{ Former::horizontal_open()
                ->rules([
                    'name' => 'Required|Max:255',
                    'email' => 'Required|Max:255|Email'
                ])
                ->id('newsletterForm')
                ->name('newsletterForm')
                ->class('form-horizontal')
            }}
                <div class="modal-body">
                    <p>
                        Preencha os campos abaixo para receber ofertas INNBatíveis.
                    </p>

                    @include('partials.modal.anti-bot-spam')

                    <div class="form-group">
                        <label class="control-label col-md-3" for="name">Seu nome</label>
                        <div class="col-md-8">
                            {{ Former::text('newsletterName')->label('')->class('form-control')->placeholder('Seu nome')->autofocus(); }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3" for="email">Seu e-mail</label>
                        <div class="col-md-8 input-group">
                            {{ Former::email('newsletterEmail')->label('')->class('form-control')->placeholder('Seu e-mail'); }}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-3 col-md-8">
                            <button type="submit" class="btn btn-primary" data-token="{{ csrf_token() }}">Cadastrar</button>
                        </div>
                    </div>
                </div>
            {{ Former::close() }}
        </div>
    </div>
</div>

<div id="newsletterResponse" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-sm modal-stylized">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><span class="entypo check"></span>E-mail cadastrado</h4>
            </div>
            <div class="modal-body">
                <p>
                    <strong>Obrigado por cadastrar-se!</strong>
                </p>
                <p>
                    Agora você poderá acompanhar nossas ofertas diariamente por e-mail.
                </p>
            </div>
        </div>
    </div>
</div>