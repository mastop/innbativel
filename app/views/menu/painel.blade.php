{{ Navigation::lists(
    Navigation::links([
          ['Dashboard', route('painel'), false, false, null, 'home'],
          ['Meus cupons', route('painel.order.offers'), false, false, null, 'user'],
          ['Meus créditos', route('painel'), false, false, null, 'user'],
          ['Editar conta', route('painel.user.edit'), false, false, null, 'user']
    ])
) }}
