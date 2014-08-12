<div id="sugira" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-sm modal-stylized">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><span class="entypo airplane"></span>Sugira uma Viagem</h4>
            </div>
            {{ Former::horizontal_open(route('suggest.send'))
                ->rules([
                    'name' => 'required|min:3', 
                    'email' => 'required|email',
                    'destiny' => 'required|min:2',
                    'suggestion' => 'required|min:10'
                ])
                ->id('sugiraForm')
                ->name('sugiraForm')
            }}
                <div class="modal-body">
                    <p>
                        Você sonha com uma viagem <strong>INNBatível</strong> e não a encontrou em nossas ofertas?
                    </p>
                    <p>
                        <strong>Sugira sua viagem pra gente!</strong>
                    </p>
                    <p>
                        Conte-nos quais são seus destinos preferidos, e iremos atrás das melhores parcerias para garantir ofertas INNBatíveis, com excelente atendimento e pelos menores preços.<br>
                        Recomende passeios, hotéis, pousadas, serviços ligados ao turismo, enfim, o que você desejar!
                    </p>
                    <p>
                        Em breve sua sugestão poderá aparecer por aqui ;)
                    </p>

                    @include('partials.modal.anti-bot-spam')

                    <div class="form-group">
                        <label class="control-label col-md-4" for="contactEmail">Nome</label>
                        <div class="col-md-8 input-group">
                            {{ Former::text('name', 'Nome')->label('')->class('form-control')->placeholder('Seu nome'); }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4" for="contactPhone">E-mail</label>
                        <div class="col-md-8">
                            {{ Former::email('email', 'E-Mail')->label('')->class('form-control')->placeholder('Seu e-mail')->value(Auth::check()?Auth::user()->email:'') }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4" for="contactCelular">Destino</label>
                        <div class="col-md-8">
                            {{ Former::text('destiny', 'Destino')->label('')->class('form-control')->placeholder('Destino'); }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4" for="contactMessage">Sugestões</label>
                        <div class="col-md-8">
                            {{ Former::textarea('suggestion', 'Sugestões')->label('')->class('form-control')
                                ->placeholder('Digite suas sugestões de viagem')
                                ->rows(10)->columns(20); }}
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

<div id="sugiraResponse" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-sm modal-stylized">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><span class="entypo check"></span>Sugestão enviada</h4>
                </div>
                <div class="modal-body">
                    <p>
                        <strong>Obrigado por compartilhar suas ideias!</strong>
                    </p>
                    <p>
                        Sua sugestão é muito importante para nós.
                    </p>
                </div>
            </div>
        </div>
    </div>
