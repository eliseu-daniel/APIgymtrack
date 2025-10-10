⚙️ Configuração de Variáveis de Ambiente

1. Copie o arquivo de exemplo .env.example para .env:
```
cp .env.example .env
```
2. Edite o arquivo .env com suas credenciais de banco de dados. Use as seguintes configurações para se conectar ao MySQL rodando em Docker:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gymtrack
DB_USERNAME=seuUser
DB_PASSWORD=suaSenha
```

🐳 Subir o MySQL com Docker

Execute o comando abaixo para iniciar apenas o container do MySQL:
```
docker-compose up -d
```

🔑 Gerar Chave da Aplicação Laravel

Com o Laravel rodando localmente, gere a chave da aplicação:
```
php artisan key:generate
```

🚀 Rodar as Migrations

Com o banco MySQL rodando e a conexão configurada, rode as migrations para criar as tabelas necessárias:
```
php artisan migrate
```

Rodar a aplicação
```
php artisan server
```

⚙️ Limpar e Cachear Configurações do Laravel

Após mudanças no .env, é recomendado limpar o cache de configuração para evitar problemas:
```
php artisan config:clear
php artisan cache:clear
php artisan config:cache
```

🎯 Gerar Model e Controller RESTful com Artisan

Criar uma Model com a migration associada:
```
php artisan make:model NomeModel -m
```

Criar uma Controller com métodos RESTful:
```
php artisan make:controller NomeController --resource
```

🐞 Verificar Logs de Erro

Se a aplicação apresentar erros ou problemas na conexão, confira os logs para diagnosticar:

 - Logs do Laravel:
 
      storage/logs/laravel.log
 - Logs do container MySQL:
```
   docker logs mysql_container
```

🧹 Parar e Remover o Container do MySQL

Para parar o container:
```
docker-compose down
```
Para remover volumes e imagens associadas:
```
docker-compose down -v --rmi all --remove-orphans
```