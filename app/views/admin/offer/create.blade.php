@section('content')

    <div class="well widget row-fluid">

        {{ Former::horizontal_open()->rules([
        	'title' => 'required',
        ]) }}

        {{ Former::text('title', 'Título')->class('span12') }}
        {{ Former::text('subtitle', 'Subtítulo')->class('span12') }}
        {{ Former::text('subsubtitle', 'Subtítulo 2')->class('span12') }}
        {{ Former::text('saveme_title', 'Título SaveMe')->class('span12') }}
        {{ Former::select('destiny_id', 'Destino')->fromQuery(Destiny::all(), 'name')->class('span12') }}

        {{ Former::select('partner_id', 'Empresa Parceira')
        ->addOption('-- SELECIONE --', null)
        ->fromQuery(User::getAllByRole('parceiro'))
        ->class('span12') }}

        {{ Former::select('ngo_id', 'Ong para Doação')
        ->addOption('-- SELECIONE --', null)
        ->fromQuery(Ngo::orderBy('name')->get(), 'name')
        ->class('span12')
        }}

        {{ Former::date('starts_on', 'Início da Oferta')->class('span12') }}
        {{ Former::date('ends_on', 'Fim da Oferta')->class('span12') }}


        {{ Former::textarea('features', 'Destaques')->rows(10)->columns(20)->class('span12') }}
        {{ Former::textarea('rules', 'Regras')->rows(10)->columns(20)->class('span12') }}



        {{ Former::actions()
          ->primary_submit('Criar Oferta')
          ->inverse_reset('Limpar') }}

        {{ Former::close() }}

    </div>

@stop
