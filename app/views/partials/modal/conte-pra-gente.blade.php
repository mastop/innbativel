<div id="conte-pra-gente" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-sm modal-stylized">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><span class="entypo heart"></span>Conte pra Gente</h4>
            </div>
            {{ Former::open_for_files(route('tell_us.send'))
                ->rules([
                    'name' => 'required|min:5',
                    'email' => 'required|email',
                    'destiny' => 'required',
                    'img' => 'required|image',
                    'travel_ate' => 'required|date_format:d/m/Y',
                    'depoiment' => 'required|min:30',
                    'authorize' => 'accepted',
                ])
                ->id('conteForm')
                ->name('conteForm')
                ->setAttribute('files', true)
            }}
                <div class="modal-body">
                    <p>
                        Fez uma viagem INNBatível conosco? Então conte pra gente!
                    </p>

                    <p>
                        Preencha os campos abaixo, inclua a melhor foto da sua viagem e o link de um video que você tenha
                        feito durante a viagem.
                    </p>
                    <div class="form-group">
                        <label class="control-label col-md-4" for="name">Nome completo</label>
                        <div class="col-md-8 input-group">
                            {{ Former::text('name', 'Nome')->label('')->class('form-control')->placeholder('Seu nome'); }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4" for="email">E-mail</label>
                        <div class="col-md-8">
                            {{ Former::email('email', 'E-Mail')->label('')->class('form-control')->placeholder('Seu e-mail')->value(Auth::check()?Auth::user()->email:'') }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4" for="destiny">Destino</label>
                        <div class="col-md-8">
                            {{ Former::text('destiny', 'Destino')->label('')->class('form-control')->placeholder('Destino'); }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4" for="travel_date">Data da viagem</label>
                        <div class="col-md-8">
                            {{ Former::text('travel_date', 'Data da viagem')->label('')->class('form-control')->placeholder('dd/mm/yyyy'); }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4" for="img">Foto da viagem</label>
                        <div class="col-md-8">
                            {{ Former::file('img', 'Foto da viagem')->label('')->class('form-control'); }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4" for="depoiment">Seu depoimento</label>
                        <div class="col-md-8">
                            {{ Former::textarea('depoiment', 'Depoimento')->label('')->class('form-control')
                                ->placeholder('Conte como foi a experiência de sua viagem e o que mais gostou')
                                ->rows(10)->columns(20); }}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-4 col-md-8">
                            <label class="authorize">
                                <input type="checkbox" id="authorize" name="authorize">
                                Autorizo o uso de minha imagem e informações fornecidas
                            </label>
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

<div id="conte-pra-gente-response" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-sm modal-stylized">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><span class="entypo check"></span>Depoimento enviado</h4>
                </div>
                <div class="modal-body">
                    <p>
                        <strong>Obrigado por enviar seu depoimento!</strong>
                    </p>
                    <p>
                        Se o seu depoimento for selecionado, vamos publicá-lo e você receberá um aviso por email.
                    </p>
                </div>
            </div>
        </div>
    </div>

<script src="{{ asset('assets/vendor/jquery.mask/jquery.mask.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#travel_date').mask('00/00/0000');
    });
</script>
