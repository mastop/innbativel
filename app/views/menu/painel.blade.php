{{ Navigation::lists(
    Navigation::links([
          ['Dashboard', route('minha-conta'), false, false, null, 'home'],
          ['Meus cupons', route('painel.order.offers'), false, false, null, 'user'],
          ['Meus créditos', route('minha-conta'), false, false, null, 'user'],
          ['Editar conta', route('painel.user.edit'), false, false, null, 'user']
    ])
) }}
