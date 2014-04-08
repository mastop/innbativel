{{ Navigation::lists(
    Navigation::links([
          ['Dashboard', route('painel'), false, false, null, 'home'],
          ['Meus cupons', route('painel'), false, false, null, 'user'],
          ['Meus créditos', route('painel'), false, false, null, 'user'],
          ['Meus Dados', route('painel'), false, false, null, 'user']
    ])
) }}
