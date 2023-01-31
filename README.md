### Desafio - Betalabs:

#### Tecnologias utilizadas

-   Laravel 9, PHP 8.1 

#### Instalação

-   Clone o projeto em seu ambiente de desenvolvimento

-   Instale as dependência necessárias para o sistema

```bash
composer install
```

-   Crie um arquivo .env baseado no arquivo .env.example e substitua os dados de acordo com o seu banco de dados:
-   Exemplo:

```bash
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=betalabs
DB_USERNAME=root
DB_PASSWORD=root
```

-   Execute o comando a seguir para criar uma chave específica de seu sistema Laravel
-   Assim como uma conexão com pastas públicas de avatar

```bash
php artisan key:generate
php artisan storage:link
```

- A seguir, os comandos necessários para criação das tabelas e dados fictícios:

```bash
php artisan migrate
ph artisan db:seed --class=DatabaseSeeder
```

- Finalmente, para iniciar e acessar o projeto:

- Autenticação:
```bash
email: admin@laravel.io
senha: password
```

### Observação

- O projeto foi criado localmente usando apenas de MAMP e conexão com o banco de dados,
Não interferindo ou adicionando quaisquer arquivos extras de configuração.

- A pasta .docs contem um coleção do Postman para testar as rotas do sistema
