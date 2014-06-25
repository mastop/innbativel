{{ Navigation::lists(
    Navigation::links([
          [Navigation::HEADER, 'Menu Parceiro', false, false, null, 'tasks'],
          ['Ofertas', route('painel.order.offers'), false, false, null, 'home'],
          ['Contrato', route('painel.contract'), false, false, null, 'user'],
          ['Pagamentos', route('painel.payment'), false, false, null, 'money'],
    ])
) }}
