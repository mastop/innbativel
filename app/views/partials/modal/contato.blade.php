<div id="contact" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-sm modal-stylized">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><span class="entypo chat"></span>Fale conosco</h4>
            </div>
            <form id="contactForm" class="form-horizontal" name="contactForm" method="post" action="send_form_contact.php" novalidate="novalidate">
                <div class="modal-body">
                    <p>
                        Envie sua mensagem preenchendo os campos abaixo.<br>
                        Muito em breve vamos entrar em contato com você.
                    </p>
                    <div class="form-group">
                        <label class="control-label col-md-4" for="contactName">Nome</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="contactName" name="contactName" placeholder="Seu nome">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4" for="contactEmail">Email</label>
                        <div class="col-md-8 input-group">
                            <!-- <span class="input-group-addon">@</span> -->
                            <input type="email" class="form-control" id="contactEmail" name="contactEmail" placeholder="Seu email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4" for="contactPhone">Telefone</label>
                        <div class="col-md-8">
                            <input type="text" maxlength="11" class="form-control" id="contactPhone" name="contactPhone" placeholder="Seu telefone (com DDD)">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4" for="contactCelular">Celular</label>
                        <div class="col-md-8">
                            <input type="text" maxlength="11" class="form-control" id="contactCelular" name="contactCelular" placeholder="Seu celular (com DDD)">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4" for="contactMessage">Sua mensagem</label>
                        <div class="col-md-8">
                            <textarea rows="6" class="form-control" id="contactMessage" name="contactMessage" placeholder="Digite suas dúvidas, sugestões ou críticas"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-4 col-md-8">
                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </div>
                    </div>
                </div>
            </form>
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