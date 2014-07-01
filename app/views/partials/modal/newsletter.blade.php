<div id="newsletter" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-sm modal-stylized">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><span class="entypo mail"></span>Receba ofertas por Email</h4>
            </div>
            {{ Former::horizontal_open(route('newsletter.save'))
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
                    <div class="form-group">
                        <label class="control-label col-md-3" for="name">Seu nome</label>
                        <div class="col-md-8">
                            {{ Former::text('name')->label('')->class('form-control')->placeholder('Seu nome')->autofocus(); }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3" for="email">Seu email</label>
                        <div class="col-md-8 input-group">
                            {{ Former::email('email')->label('')->class('form-control')->placeholder('Seu email'); }}
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

<script>
jQuery( document ).ready( function( $ ) {
    $('#newsletterForm').on('submit', function() {
        $.post(
            $( this ).prop('action'),
            {
                "_token": $( this ).find( 'input[name=_token]' ).val(),
                "name": $('#name').val(),
                "email": $('#email').val()
            },
            function( data ) {
               if(data.status=="error"){
                   alert(data.msg);
               }else{
                   $('#newsletterForm').get(0).reset();
                   $("#newsletter").modal('hide');
                   $('#newsletterResponse').modal('show');
               }
            },
            'json'
        );
        return false;
    });
});
</script>