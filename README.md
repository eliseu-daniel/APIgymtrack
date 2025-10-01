⚙️ Variáveis de Ambiente (.env)

Troque o nome do arquivo .env.example para .env
Troque o nome das variaveis a seguir para os seus dados de conexao
```
DB_HOST=localhost
DB_USER=seuUser
DB_PASSWORD=suaSenha
DB_NAME=gymtrack
```

📦 Como subir o ambiente

No terminal, execute:

```
docker-compose up -d
```

✅ Verificar se o container está rodando

```
docker ps
```

🛠 Acessar o MySQL via terminal

```
docker exec -it mysql_container mysql -u ${DB_USER} -p
```

🧹 Parar e remover containers
```
docker-compose down
```
ou para apagar tudo
```
docker-compose down -v --rmi all --remove-orphans
```
