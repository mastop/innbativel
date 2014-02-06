# Site Innbatível.

## Configuração

1. Verificar se a instalação está na pasta correta configurada no NGINX.

2. Verificar se a pasta possui as permissões corretas, você também pode rodar o arquivo perms.sh dentro da pasta scripts.

  ```sh scripts/perms.sh```

3. Configurar o app/config/database.

## Instalação

1. Clonar repositório git com o seguinte comando:

  ```bash
  git clone https://bitbucket.org/programacao_innbativel/innbativel-2.0.git
  ```

2. Rodar o composer para gerar o autoload correto.

  ```php composer install```

3. Nunca utilizar o composer update pois o Laravel usa a versão 4.1 e os pacotes não são atualizados de acordo com a versão atual do Laravel.

4. Rodar o migrate

  ```php artisan migrate --env=local```

5. Rodar o Seed

  ```php artisan db:seed --env=local```
