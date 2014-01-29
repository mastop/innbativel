{{ Navigation::lists(
    Navigation::links([
          [Navigation::HEADER, 'Menu Administrativo', false, false, null, 'tasks'],
          ['Dashboard', route('admin'), false, false, null, 'home'],
          ['Usuários', route('admin.user'), false, false, null, 'user'],
          ['Papéis', route('admin.role'), false, false, null, 'book'],
          ['Permissões', route('admin.perm'), false, false, null, 'leaf'],
          ['Ofertas', route('admin.offer'), false, false, null, 'fire'],
          ['Ordens', route('admin.order'), false, false, null, 'leaf'],
          ['Saveme', route('admin.saveme'), false, false, null, 'leaf'],
          ['Pré-Reservas', route('admin.prebooking'), false, false, null, 'leaf'],
          ['Indicações', route('admin.indication'), false, false, null, 'leaf'],
          ['Indicação (Créditos)', route('admin.credit_indication'), false, false, null, 'leaf'],
          ['Categorias', route('admin.category'), false, false, null, 'leaf'],
          ['Sub-Categorias', route('admin.subcategory'), false, false, null, 'leaf'],
          ['Coupon', route('admin.coupon'), false, false, null, 'leaf'],
          ['Comentários', route('admin.comment'), false, false, null, 'leaf'],
          ['NGO', route('admin.ngo'), false, false, null, 'leaf'],
          ['Gênero', route('admin.genre'), false, false, null, 'leaf'],
          ['Fale Conosco', route('admin.tellus'), false, false, null, 'leaf'],
          ['Testemunho de Parceiros', route('admin.partner_testimony'), false, false, null, 'leaf'],
          ['Sugestões', route('admin.suggest'), false, false, null, 'leaf'],
          ['Configurações', route('admin.config'), false, false, null, 'cogs'],
          ['FAQ\'s', route('admin.faq'), false, false, null, 'question-sign'],
    ])
) }}
