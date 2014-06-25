@if(Auth::user()->is('administrador') || Auth::user()->is('programador'))
{{ Navigation::lists(
    Navigation::links([
          [Navigation::HEADER, 'Menu Administrativo', false, false, null, 'tasks'],
          ['Dashboard', route('admin'), false, false, null, 'home'],
          ['Usuários', route('admin.user'), false, false, null, 'user'],
          ['Parceiros', route('admin.partner'), false, false, null, 'user'],
          ['Papéis', route('admin.role'), false, false, null, 'book'],
          ['Permissões', route('admin.perm'), false, false, null, 'leaf'],
          ['Ofertas', route('admin.offer'), false, false, null, 'fire'],
          ['Destinos', route('admin.destiny'), false, false, null, 'fire'],
          ['Feriados', route('admin.holiday'), false, false, null, 'fire'],
          ['Itens Inclusos', route('admin.included'), false, false, null, 'fire'],
          ['Tags', route('admin.tag'), false, false, null, 'fire'],
          ['Pagamentos', route('admin.order'), false, false, null, 'leaf'],
          ['Pagamentos aos Parceiros', route('admin.payment'), false, false, null, 'money'],
          ['Transações', route('admin.transaction'), false, false, null, 'money'],
          ['Categorias', route('admin.category'), false, false, null, 'leaf'],
          ['Cupons de Desconto', route('admin.coupon'), false, false, null, 'leaf'],
          ['ONGs', route('admin.ngo'), false, false, null, 'leaf'],
          ['Gênero', route('admin.genre'), false, false, null, 'leaf'],
          ['Conte pra gente', route('admin.tellus'), false, false, null, 'leaf'],
          ['Depoimento de parceiros', route('admin.partner_testimony'), false, false, null, 'leaf'],
          ['Sugestões', route('admin.suggest'), false, false, null, 'leaf'],
          ['FAQ\'s', route('admin.faq'), false, false, null, 'question-sign'],
          ['Sugira uma Viagem', route('admin.suggest'), false, false, null, 'question-sign'],
          ['Contratos', route('admin.contract'), false, false, null, 'question-sign'],
    ])
) }}
@elseif(Auth::user()->is('gerente') || Auth::user()->is('marketing') || Auth::user()->is('atendimento') || Auth::user()->is('designer'))
{{ Navigation::lists(
    Navigation::links([
        [Navigation::HEADER, 'Menu', false, false, null, 'tasks'],
        ['Dashboard', route('admin'), false, false, null, 'home'],
        ['Usuários', route('admin.user'), false, false, null, 'user'],
        ['Parceiros', route('admin.partner'), false, false, null, 'user'],
        ['Ofertas', route('admin.offer'), false, false, null, 'fire'],
        ['Destinos', route('admin.destiny'), false, false, null, 'fire'],
        ['Feriados', route('admin.holiday'), false, false, null, 'fire'],
        ['Itens Inclusos', route('admin.included'), false, false, null, 'fire'],
        ['Tags', route('admin.tag'), false, false, null, 'fire'],
        ['Pagamentos', route('admin.order'), false, false, null, 'leaf'],
        ['Categorias', route('admin.category'), false, false, null, 'leaf'],
        ['Cupons de Desconto', route('admin.coupon'), false, false, null, 'leaf'],
        ['ONGs', route('admin.ngo'), false, false, null, 'leaf'],
        ['Gênero', route('admin.genre'), false, false, null, 'leaf'],
        ['Conte pra gente', route('admin.tellus'), false, false, null, 'leaf'],
        ['Depoimento de parceiros', route('admin.partner_testimony'), false, false, null, 'leaf'],
        ['Sugestões', route('admin.suggest'), false, false, null, 'leaf'],
        ['FAQ\'s', route('admin.faq'), false, false, null, 'question-sign'],
        ['Sugira uma Viagem', route('admin.suggest'), false, false, null, 'question-sign'],
        ['Contratos', route('admin.contract'), false, false, null, 'question-sign'],
    ])
) }}
@else
{{ Navigation::lists(
    Navigation::links([
        [Navigation::HEADER, 'Menu', false, false, null, 'tasks'],
        ['Dashboard', route('admin'), false, false, null, 'home'],
        ['Usuários', route('admin.user'), false, false, null, 'user'],
        ['Parceiros', route('admin.partner'), false, false, null, 'user'],
        ['Ofertas', route('admin.offer'), false, false, null, 'fire'],
        ['Destinos', route('admin.destiny'), false, false, null, 'fire'],
        ['Feriados', route('admin.holiday'), false, false, null, 'fire'],
        ['Itens Inclusos', route('admin.included'), false, false, null, 'fire'],
        ['Tags', route('admin.tag'), false, false, null, 'fire'],
        ['Pagamentos', route('admin.order'), false, false, null, 'leaf'],
        ['Categorias', route('admin.category'), false, false, null, 'leaf'],
        ['ONGs', route('admin.ngo'), false, false, null, 'leaf'],
        ['Gênero', route('admin.genre'), false, false, null, 'leaf'],
        ['Conte pra gente', route('admin.tellus'), false, false, null, 'leaf'],
        ['Depoimento de parceiros', route('admin.partner_testimony'), false, false, null, 'leaf'],
        ['Sugestões', route('admin.suggest'), false, false, null, 'leaf'],
        ['FAQ\'s', route('admin.faq'), false, false, null, 'question-sign'],
        ['Sugira uma Viagem', route('admin.suggest'), false, false, null, 'question-sign'],
        ['Contratos', route('admin.contract'), false, false, null, 'question-sign'],
    ])
) }}
@endif
