# Projeto Chat App

Este é um sistema de chat em tempo real construído com Laravel no backend e React no frontend.
Este documento fornece uma visão geral de como instalar e configurar o sistema.

## Pré-requisitos
- PHP (>= 8.x)
- Composer
- Node.js (>= 14.x)
- MySQL (ou outro banco de dados compatível)

## Passo a Passo de Instalação

1. **Clone o Repositório**
   ```bash
   git clone https://github.com/seu-usuario/seu-repositorio.git
   cd seu-repositorio
   ```

2. **Instale as depencências**
    ```
    composer install
    ```
3. ** Configuração do Banco de Dados **
    - Configure o arquivo .env:

```
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:WjZKoxzb6vmdxG7ab0Dip3UxMDV1lLtewpWE+RPqyUU=
APP_DEBUG=true
APP_TIMEZONE=UTC
APP_URL=http://localhost:8000
FRONTEND_URL=http://localhost:3000

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file
# APP_MAINTENANCE_STORE=database

PHP_CLI_SERVER_WORKERS=4

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=chat_app
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database
CACHE_PREFIX=

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=log
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="${APP_NAME}"

API_CHAT_SOCKET_URL=http://localhost:7000/
```
- Rode as migrações para criar as tabelas no banco de dados.
```
php artisan migrate
```

4. ** Configuração CSRF para Rota de API **
   - Devido à atualização do Laravel, é necessário adicionar a rota api/* à lista de exceções CSRF.
   - Abra o arquivo ```VerifyCsrfToken.php``` em:
     ```
      vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/VerifyCsrfToken.php
     ```
   - Adicione a rota ``` api/* ``` na propriedade ``` $except ```, como mostrado abaixo:
     ```
     protected $except = ['api/*'];
    ```

5. ** Após estas configurações, o backend estará pronto, mas ainda falta instalar as dependências do frontend e da api de socket, a documentação de ambos explicará como **
