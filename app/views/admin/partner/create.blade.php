@section('content')

    <div class="well widget row-fluid">

        {{ Former::horizontal_open()->rules([
        	'email' => 'required|email',
            'profile[first_name]' => 'required',
            'profile[company_name]' => 'required',
        	'profile[cnpj]' => 'required',
            'profile[street]' => 'required',
            'profile[number]' => 'required',
        	'profile[neighborhood]' => 'required',
        	'profile[city]' => 'required',
        	'profile[state]' => 'required|exists:states,id',
            'profile[country]' => 'required',
        	'profile[telephone]' => 'required',
        ]) }}

        {{ Former::email('email', 'E-mail')->class('span12') }}
        {{ Former::text('profile[first_name]', 'Nome')->class('span12') }}
        {{ Former::text('profile[company_name]', 'Razão Social')->class('span12') }}
        {{ Former::text('profile[cnpj]', 'CNPJ')->class('span12') }}
        {{ Former::text('profile[zip]', 'CEP')->class('span12') }}
        {{ Former::text('profile[street]', 'Endereço')->class('span12') }}
        {{ Former::text('profile[number]', 'Número')->class('span12') }}
        {{ Former::text('profile[complement]', 'Complemento')->class('span12') }}
        {{ Former::text('profile[neighborhood]', 'Bairro')->class('span12') }}
        {{ Former::text('profile[city]', 'Cidade')->class('span12') }}
        {{ Former::select('profile[state]', 'Estado')
            ->addOption('-- selecione uma opção --', null)
            ->fromQuery(DB::table('states')->get(['id', 'name']), 'name', 'id')
            ->class('span12')
        }}
        {{ Former::text('profile[country]', 'País')->class('span12') }}
        {{ Former::text('profile[site]', 'Site')->class('span12') }}
        {{ Former::text('profile[coordinates]', 'Coordenadas')->class('span12') }}
        {{ Former::text('profile[telephone]', 'Telefone')->class('span12') }}
        {{ Former::text('profile[telephone2]', 'Telefone 2')->class('span12') }}
        {{ Former::text('api_key', 'API Key')->class('span12') }}
        <div class="control-group">
        	<a href="javascript: generateAPIKey();">Gerar nova API Key</a></label>
        </div>

        {{ Former::actions()
          ->primary_submit('Enviar')
          ->inverse_reset('Limpar') }}

        {{ Former::close() }}

    </div>

    <script type="text/javascript">

    function s4() {
	  return Math.floor((1 + Math.random()) * 0x10000)
	             .toString(16)
	             .substring(1);
	};

	function guid() {
	  return s4() + '-' + s4() + '-' + s4();
	}

	function generateAPIKey(){
		document.getElementById('api_key').value = btoa(guid());
	}

    </script>

@stop
