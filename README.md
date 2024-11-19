### Passo a passo
Clone Repositório
```sh
git clone https://github.com/filgueirasjulio/desafio-acp-group.git
```

Crie o Arquivo .env
```sh
cp .env.example .env
```

Suba os containers do projeto
```sh
docker-compose up -d
```

Acessar o container
```sh
docker-compose exec app bash
```

Instalar as dependências do projeto
```sh
composer install
```

Gerar a key do projeto Laravel
```sh
php artisan key:generate
```

Gerar as migrates
```sh
php artisan migrate --seed
```

Gerar a documentação swagger
```sh
php artisan l5-swagger:generate
```

Acessar o projeto
[http://localhost:8989](http://localhost:8989)

Acessar a documentação
[http://localhost:8989](http://localhost:8989/api/documentation)