🏋️‍♂️ GymTrack API

API REST desenvolvida em Laravel para gerenciamento de pacientes, educadores físicos, dietas, treinos e acompanhamento físico do sistema GymTrack.

O projeto utiliza Docker Compose para rodar a aplicação Laravel e o banco de dados MySQL.

🚀 Tecnologias

- PHP 8.2
- Laravel 12
- MySQL (Docker)
- Docker & Docker Compose
- Laravel Sanctum 4

📦 Requisitos

Você precisa ter instalado:

- Docker
- Docker Compose

🛠️ Instalação

1️⃣ Clone o repositório

```
git clone https://github.com/eliseu-daniel/APIgymtrack.git
cd APIgymtrack
```

2️⃣ Configure o .env

```
cp .env.example .env
```

Configure as variáveis de ambiente conforme necessário. As configurações padrão já estão ajustadas para Docker:

```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=gymtrack
DB_USERNAME=user
DB_PASSWORD=password
MYSQL_ROOT_PASSWORD=password
```

3️⃣ Suba os containers

```
docker compose up --build -d
```

Isso irá construir a imagem da aplicação e subir os containers para a app e o banco de dados.

4️⃣ Rode as migrations (dentro do container)

```
docker compose exec app php artisan migrate
```

(Opcional) Rode os seeders:

```
docker compose exec app php artisan db:seed
```

ou caso de erro de seed, assim reseta o banco ja com criando com o seed
```

docker compose exec app php artisan migrate:fresh --seed
```

▶️ Executando a API

A API estará disponível em:

http://localhost:8000

Para parar os containers:

```
docker compose down
```
ou remover todos os containers do sistema
```
sudo docker rm -f (sudo docker ps -aq)
```

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
```
