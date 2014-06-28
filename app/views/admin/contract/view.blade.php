@section('content')

    <div class="well widget row-fluid">

        {{ Former::horizontal_open() }}

        {{ Former::populate($contract) }}

        <div class="control-group"><h1>Contrato #{{ $contract->id }}</h1></div>

        <div class="control-group"><h1>Empresa</h1></div>

        <div class="control-group required">
            <label for="partner" class="control-label">Nome</label>
            <div class="controls">{{ $contract->partner->profile->first_name.(isset($contract->partner->profile->last_name)?(' '.$contract->partner->profile->last_name):'') }}</div>
        </div>

        <div class="control-group"><h1>Consultor</h1></div>

        <div class="control-group required">
            <label for="consultant" class="control-label">Nome</label>
            <div class="controls">{{ $contract->consultant->profile->first_name.(isset($contract->consultant->profile->last_name)?(' '.$contract->consultant->profile->last_name):'') }}</div>
        </div>

        <div class="control-group"><h1>Dados do contratante</h1></div>

        <div class="control-group required">
            <label for="company_name" class="control-label">Razão social</label>
            <div class="controls">{{ $contract->company_name }}</div>
        </div>
        <div class="control-group required">
            <label for="cnpj" class="control-label">CNPJ</label>
            <div class="controls">{{ $contract->cnpj }}</div>
        </div>
        <div class="control-group required">
            <label for="trading_name" class="control-label">Nome fantasia</label>
            <div class="controls">{{ $contract->trading_name }}</div>
        </div>
        <div class="control-group required">
            <label for="address" class="control-label">Endereço</label>
            <div class="controls">{{ $contract->address }}</div>
        </div>
        <div class="control-group required">
            <label for="complement" class="control-label">Complemento</label>
            <div class="controls">{{ $contract->complement }}</div>
        </div>
        <div class="control-group required">
            <label for="neighborhood" class="control-label">Bairro</label>
            <div class="controls">{{ $contract->neighborhood }}</div>
        </div>
        <div class="control-group required">
            <label for="zip" class="control-label">CEP</label>
            <div class="controls">{{ $contract->zip }}</div>
        </div>
        <div class="control-group required">
            <label for="city" class="control-label">Cidade</label>
            <div class="controls">{{ $contract->city }}</div>
        </div>
        <div class="control-group required">
            <label for="state" class="control-label">Estado</label>
            <div class="controls">{{ $contract->state }}</div>
        </div>

        <div class="control-group"><h1>Representantes legais com poderes previstos no Contrato Social</h1></div>

        <div class="control-group required">
            <label for="agent1_name" class="control-label">Nome representante 1</label>
            <div class="controls">{{ $contract->agent1_name }}</div>
        </div>
        <div class="control-group required">
            <label for="agent1_cpf" class="control-label">CPF representante 1</label>
            <div class="controls">{{ $contract->agent1_cpf }}</div>
        </div>
        <div class="control-group required">
            <label for="agent1_telephone" class="control-label">Telefone representante 1</label>
            <div class="controls">{{ $contract->agent1_telephone }}</div>
        </div>

        <div class="control-group required">
            <label for="agent2_name" class="control-label">Nome representante 2</label>
            <div class="controls">{{ $contract->agent2_name }}</div>
        </div>
        <div class="control-group required">
            <label for="agent2_cpf" class="control-label">CPF representante 2</label>
            <div class="controls">{{ $contract->agent2_cpf }}</div>
        </div>
        <div class="control-group required">
            <label for="agent2_telephone" class="control-label">Telefone representante 2</label>
            <div class="controls">{{ $contract->agent2_telephone }}</div>
        </div>
        
        <div class="control-group"><h1>Dados Bancários (devem necessariamente ser dados vinculados ao CNPJ e Razão Social acima)</h1></div>

        <div class="control-group required">
            <label for="bank_name" class="control-label">Nome do banco</label>
            <div class="controls">{{ $contract->bank_name }}</div>
        </div>
        <div class="control-group required">
            <label for="bank_number" class="control-label">Número do banco</label>
            <div class="controls">{{ $contract->bank_number }}</div>
        </div>
        <div class="control-group required">
            <label for="bank_holder" class="control-label">Ttular</label>
            <div class="controls">{{ $contract->bank_holder }}</div>
        </div>
        <div class="control-group required">
            <label for="bank_agency" class="control-label">Agncia</label>
            <div class="controls">{{ $contract->bank_agency }}</div>
        </div>
        <div class="control-group required">
            <label for="bank_account" class="control-label">Conta</label>
            <div class="controls">{{ $contract->bank_account }}</div>
        </div>
        <div class="control-group required">
            <label for="bank_cpf_cnpj" class="control-label">CPF ou CNPJ</label>
            <div class="controls">{{ $contract->bank_cpf_cnpj }}</div>
        </div>
        <div class="control-group required">
            <label for="bank_financial_email" class="control-label">E-mail do dpto financeiro</label>
            <div class="controls">{{ $contract->bank_financial_email }}</div>
        </div>

        <div class="control-group"><h1>Regras do cupom</h1></div>

        <div class="control-group required">
            <label for="initial_term" class="control-label">Prazo inicial de utilização</label>
            <div class="controls">{{ $contract->initial_term }}</div>
        </div>
        <div class="control-group required">
            <label for="final_term" class="control-label">Prazo final de utilização</label>
            <div class="controls">{{ $contract->final_term }}</div>
        </div>
        <div class="control-group required">
            <label for="n_people" class="control-label">Nº de pessoas por cupom</label>
            <div class="controls">{{ $contract->n_people }}</div>
        </div>
        <div class="control-group required">
            <label for="restriction" class="control-label">Restrição</label>
            <div class="controls">{{ $contract->restriction }}</div>
        </div>
        <div class="control-group required">
            <label for="has_scheduling" class="control-label">Agendamento?</label>
            <div class="controls">{{ ($contract->has_scheduling == 1)?'Sim':'Não' }}</div>
        </div>

        <span id="yes_has_scheaduling">
            <div class="control-group required">
                <label for="sched_contact" class="control-label">Telefone, e-mail e/ou site para agendamento</label>
                <div class="controls">{{ $contract->sched_contact }}</div>
            </div>
            <div class="control-group required">
                <label for="sched_dates" class="control-label">Dias e horários para agendamento</label>
                <div class="controls">{{ $contract->sched_dates }}</div>
            </div>
            <div class="control-group required">
                <label for="sched_max_date" class="control-label">Data limite para agendamento, se existir</label>
                <div class="controls">{{ $contract->sched_max_date }}</div>
            </div>
            <div class="control-group required">
                <label for="sched_min_antecedence" class="control-label">Antecedência mínima para agendamento</label>
                <div class="controls">{{ $contract->sched_min_antecedence }}</div>
            </div>
        </span>

        @if($contract->has_scheduling == false)
        <script type="text/javascript">$('#yes_has_scheaduling').hide()</script>
        @endif

        <div class="control-group"><h1>Detalhamento dos serviços oferecidos</h1></div>

        <div class="control-group required">
            <label for="features" class="control-label">Destaques</label>
            <div class="controls">{{ $contract->features }}</div>
        </div>
        <div class="control-group required">
            <label for="rules" class="control-label">Regras</label>
            <div class="controls">{{ $contract->rules }}</div>
        </div>

        <div class="control-group">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Opção da oferta</th>
                        <th>Preço original (R$)</th>
                        <th>Preço final (R$)</th>
                        <th>Desconto oferecido ao usuário (%)</th>
                        <th>Valor repasse por cupom (R$)</th>
                        <th>Número máximo de cupons</th>
                    </tr>
                </thead>
                <tbody id="options">
                    @foreach($contract_options AS $contract_option)
                    <tr>
                        <td>{{ $contract_option->title }}</td>
                        <td>{{ $contract_option->price_original }}</td>
                        <td>{{ $contract_option->price_with_discount }}</td>
                        <td>{{ $contract_option->percent_off }}</td>
                        <td>{{ $contract_option->transfer }}</td>
                        <td>{{ $contract_option->max_qty }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="control-group">
            <h1>Cláusulas</h1>

            {{ $contract->clauses }}
        </div>

        <div class="control-group"><h1>Outros dados</h1></div>

        <div class="control-group required">
            <label for="is_signed" class="control-label">Contrato assinado?</label>
            <div class="controls">{{ (($contract->is_signed == true)?'Sim':'Não') }}</div>
        </div>
        <div class="control-group required">
            <label for="ip" class="control-label">IP do anunciante parceiro no momento da assinatura</label>
            <div class="controls">{{ $contract->ip }}</div>
        </div>
        <div class="control-group required">
            <label for="signed_at" class="control-label">Contrato assinado em</label>
            <div class="controls">{{ (($contract->is_signed == true)?date("d/m/Y H:i:s", strtotime($contract->signed_at)):'-') }}</div>
        </div>
        <div class="control-group required">
            <label for="created_at" class="control-label">Contrato criado em</label>
            <div class="controls">{{ date("d/m/Y H:i:s", strtotime($contract->created_at)) }}</div>
        </div>
        <div class="control-group required">
            <label for="updated_at" class="control-label">Última atualização</label>
            <div class="controls">{{ date("d/m/Y H:i:s", strtotime($contract->updated_at)) }}</div>
        </div>

        {{ Former::close() }}

    </div>

@stop
