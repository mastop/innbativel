<div id="sugira" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-sm modal-stylized">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><span class="entypo airplane"></span>Sugira uma Viagem</h4>
            </div>
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
                {{ Form::open(array('route' => 'suggest.create')) }}
                <p>
                    {{ Former::text('name', 'Nome')->class('span12') }}
                </p>
                <p>
                    {{ Former::email('email', 'E-Mail')->class('span12') }}
                </p>
                <p>
                    {{ Former::text('destiny', 'Destino')->class('span12') }}
                </p>
                <p>
                    {{ Former::textarea('suggestion', 'Sugest&atilde;o')->class('span12') }}
                </p>
                {{ Former::actions()
                ->primary_submit('Enviar')
                ->inverse_reset('Limpar')}}
                {{ Form::close() }}
            </div>
            </form>
        </div>
    </div>
</div>
