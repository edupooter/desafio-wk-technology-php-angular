## Solução proposta para o desafio WK Technology

Projeto usado durante o processo seletivo para desenvolvedor PHP + Angular na WK Technology.

- Backend: PHP 8 com Laravel 9 e MySQL 8
- Frontend: Angular ...

### Ambiente local

Desenvolvido com Laravel Sail no Ubuntu via WSL2 com Docker Engine nativo do Linux.

### Protocolo da API

Exemplos de requisições HTTP na pasta **http-requests**

### Backend
#### Instalação das dependências
```
$ cd laravel-app
$ composer install
```

#### Inicialização dos serviços
```
$ cd laravel-app
$ ./vendor/bin/sail up -d
$ ./vendor/bin/sail artisan migrate
```

#### Execução dos **testes**
```
$ cd laravel-app
$ ./vendor/bin/sail artisan test
```
