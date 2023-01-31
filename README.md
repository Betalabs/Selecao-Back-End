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

```bash
sail artisan key:generate
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
