@section('content')

    <div class="well widget row-fluid">

        {{ Former::horizontal_open()->rules([
        	'title' => 'required',
        ]) }}

        {{ Former::text('title', 'Título')->class('span12') }}
        {{ Former::text('subtitle', 'Subtítulo')->class('span12') }}
        {{ Former::text('subsubtitle', 'Subtítulo 2')->class('span12') }}
        {{ Former::text('saveme_title', 'Título SaveMe')->class('span12') }}
        {{ Former::select('destiny_id', 'Destino')->fromQuery(Destiny::all(), 'name')->class('span12  chosen-select') }}

        {{ Former::select('partner_id', 'Empresa Parceira')
        ->addOption(null)
        ->data_placeholder('Selecione uma Empresa Parceira')
        ->fromQuery(User::getAllByRole('parceiro'))
        ->class('span12 chosen-select') }}

        {{ Former::select('ngo_id', 'ONG para Doação')
        ->data_placeholder('Selecione uma ONG')
        ->fromQuery(Ngo::orderBy('name')->get(), 'name')
        ->class('span12 chosen-select')
        }}

        {{ Former::date('starts_on', 'Início da Oferta')->class('span12') }}
        {{ Former::date('ends_on', 'Fim da Oferta')->class('span12') }}


        {{ Former::textarea('features', 'Destaques')->rows(10)->columns(20)->class('span12') }}
        {{ Former::textarea('rules', 'Regras')->rows(10)->columns(20)->class('span12') }}


        {{ Former::multiselect('offers_includes', 'Inclusos')
        ->fromQuery(Included::orderBy('title')->get())
        ->data_placeholder('Selecione os Itens Inclusos')
        ->class('span12  chosen-select') }}

        {{ Former::select('tell_us_id', 'Depoimento de Cliente')
        ->addOption(null)
        ->fromQuery(TellUs::orderBy('destiny')->get())
        ->data_placeholder('Selecione um Depoimento')
        ->class('span12 chosen-select') }}

        {{ Former::actions()
          ->primary_submit('Criar Oferta')
          ->inverse_reset('Limpar') }}

        {{ Former::close() }}


        <script src="{{ asset('assets/themes/floripa/backend/js/offer.create.js') }}"></script>

    </div>

@stop
