{{ Former::horizontal_open()->class('row-fluid')->rules(['email' => 'required']) }}
{{ Former::text('email')->class('span12')->placeholder('E-mail') }}
<br>
<div class="login-btn">
    {{ Former::danger_submit('Cadastrar-me')->class('btn btn-danger btn-block') }}
</div>
{{ Former::close() }}
