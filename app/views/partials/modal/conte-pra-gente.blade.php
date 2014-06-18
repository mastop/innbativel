<div id="conte-pra-gente" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-sm modal-stylized">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><span class="entypo heart"></span>Conte pra Gente</h4>
            </div>
            <div class="modal-body">
                <p>
                    Fez uma viagem INNBatível conosco? Então conte pra gente!
                </p>

                <p>
                    Preencha os campos abaixo, inclua a melhor foto da sua viagem e o link de um video que você tenha
                    feito durante a viagem.
                </p>
                {{ Form::open(array('route' => 'tellus.create')) }}
                <p>
                    {{ Former::text('name', 'Nome')->class('span12') }}
                </p>

                <p>
                    {{ Former::email('email', 'E-mail')->class('span12') }}
                </p>

                <p>
                    {{ Former::text('destiny', 'Destino da Viagem')->class('span12') }}
                </p>

                <p>
                    {{ Former::date('travelDate', 'Data da Viagem')->class('span12') }}
                </p>

                <p>
                    {{ Former::textarea('deppoiment', 'Seu depoimento')->class('span12') }}
                </p>
                <!--
                <p>
                    {{ Former::file('photo', 'Foto da viagem')->accept('jpg,jpeg,gif,png')->class('span12') }}
                </p>

                <p>
                    {{ Former::file('video', 'Vídeo da viagem')->accept('avi,wma,wmp,divx')->class('span12') }}
                </p>
                -->
                <p>
                    {{ Former::checkbox('authorize', '')->class('span12') }} Autorizo o uso de minha imagem e
                    informações
                    fornecidas
                </p>
                {{ Former::actions()
                ->primary_submit('Enviar')
                ->inverse_reset('Limpar')}}
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
