🏋️‍♂️ GymTrack API

API REST desenvolvida em Laravel para gerenciamento de pacientes, educadores físicos, dietas, treinos e acompanhamento físico do sistema GymTrack.

O projeto utiliza Docker Compose apenas para o banco de dados, enquanto a aplicação Laravel roda localmente.

🚀 Tecnologias

- PHP 8.2
- Laravel 12
- MySQL (Docker)
- Docker & Docker Compose
- Laravel Sanctum 4

📦 Requisitos

Você precisa ter instalado:

- PHP 8.2

- Composer

- Docker

- Docker Compose

🛠️ Instalação
1️⃣ Clone o repositório

```
git clone https://github.com/eliseu-daniel/APIgymtrack.
```
```
cd APIgymtrack
```
2️⃣ Suba apenas o banco de dados
```
docker-compose up -d
```

Isso irá subir somente o container do MySQL.

3️⃣ Instale as dependências
```
composer install
```

4️⃣ Configure o .env
```
cp .env.example .env
```

Configure a conexão com o banco:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gymtrack
DB_USERNAME=root
DB_PASSWORD=root
```

(ajuste conforme seu docker-compose.yml)

5️⃣ Gere a chave
```
php artisan key:generate
```
6️⃣ Rode as migrations
```
php artisan migrate
```

(Opcional)
```
php artisan db:seed
```
▶️ Executando a API
```
php artisan serve
```

API disponível em:

http://localhost:8000

🔐 Autenticação

A API usa Laravel Sanctum.

Login

POST /api/login
```js
{
  "email": "educador@email.com",
  "password": "123456"
}


Resposta:

{
  "status": true,
  "token": "TOKEN",
  "educator": { ... }
}


Use o token nas requisições:

Authorization: Bearer TOKEN

📄 Licença

MIT