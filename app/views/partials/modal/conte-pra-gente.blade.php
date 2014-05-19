<div id="conte-pra-gente" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-sm modal-stylized">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><span class="entypo heart"></span>Conte pra Gente</h4>
            </div>
            <form id="conteForm" class="form-horizontal" name="trabalheForm" method="post" action="send_form_trabalhe.php" novalidate="novalidate">
                <div class="modal-body">
                    <p>
                        Fez uma viagem INNBatível conosco? Então conte pra gente!
                    </p>
                    <p>
                        Preencha os campos abaixo, inclua a melhor foto da sua viagem e o link de um video que você tenha feito durante a viagem.
                    </p>
                    <div class="form-group">
                        <label class="control-label col-md-4" for="conteFullName">Nome completo</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="conteFullName" name="conteFullName" placeholder="Seu nome completo">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4" for="conteEmail">Email</label>
                        <div class="col-md-8 input-group">
                            <input type="email" class="form-control" id="conteEmail" name="conteEmail" placeholder="Seu email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4" for="conteDestiny">Destino da viagem</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="conteDestiny" name="conteDestiny" placeholder="Destino de sua viagem">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4" for="conteDate">Data da viagem</label>
                        <div class="col-md-8">
                            <input type="date" class="form-control" id="conteDate" name="conteDate" placeholder="Complemento (se houver)">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4" for="conteDepo">Seu depoimento</label>
                        <div class="col-md-8">
                            <textarea rows="5" class="form-control" id="conteDepo" name="conteDepo" placeholder="Conte como foi a experiência de sua viagem e o que mais gostou"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4" for="conteFoto">Foto da viagem</label>
                        <div class="col-md-8">
                            <input type="file" class="form-control" id="conteFoto" name="conteFoto" placeholder="Escolha seu CV">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4" for="conteVideo">Video da viagem</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="conteVideo" name="conteVideo" placeholder="http://youtube.com/seu_video_da_viagem">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-4 col-md-8">
                            <label class="autorizo">
                                <input type="checkbox" id="conteAutorizo" name="conteAutorizo">
                                Autorizo o uso de minha imagem e informações fornecidas
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-4 col-md-8">
                            <button type="submit" class="btn">Enviar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="conte-pra-gente-response" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-sm modal-stylized">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
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