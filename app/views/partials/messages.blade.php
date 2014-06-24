<div class="messages-wrapper container">
    <div id="messages">
        @if (count($errors) > 0)
            {{ Alert::error('Existem erros de preenchimento, verifique o formulário a baixo.') }}
        @endif

        @if ($message = Session::get('success'))
            {{ Alert::success($message) }}
        @endif

        @if ($message = Session::get('error'))
            {{ Alert::error($message) }}
        @endif

        @if ($message = Session::get('warning'))
            {{ Alert::warning($message) }}
        @endif

        @if ($message = Session::get('info'))
            {{ Alert::info($message) }}
        @endif
    </div>
</div>
