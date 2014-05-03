<div id="newsletter" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-sm modal-stylized">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><span class="entypo mail"></span>Receba ofertas por Email</h4>
            </div>
            <form id="newsletterForm" class="form-horizontal" name="newsletterForm" method="post" action="send_form_newsletter.php" novalidate="novalidate">
                <div class="modal-body">
                    <p>
                        Preencha os campos abaixo para receber ofertas INNBatíveis.
                    </p>
                    <div class="form-group">
                        <label class="control-label col-md-3" for="newsletterName">Seu nome</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="newsletterName" name="newsletterName" placeholder="Seu nome">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3" for="newsletterEmail">Seu email</label>
                        <div class="col-md-8 input-group">
                            <input type="email" class="form-control" id="newsletterEmail" name="newsletterEmail" placeholder="Seu email">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-3 col-md-8">
                            <button type="submit" class="btn btn-primary">Cadastrar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="newsletterResponse" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-sm modal-stylized">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><span class="entypo check"></span>Email cadastrado</h4>
            </div>
            <div class="modal-body">
                <p>
                    <strong>Obrigado por cadastrar-se!</strong>
                </p>
                <p>
                    Agora você poderá acompanhar nossas ofertas diariamente por email.
                </p>
            </div>
        </div>
    </div>
</div>