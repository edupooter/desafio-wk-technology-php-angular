## Solução proposta para o desafio

Projeto usado durante o processo seletivo para desenvolvedor PHP/Angular na WK Technology.

### Ambiente

Desenvolvido com Laravel Sail no Ubuntu via WSL2 com Docker Engine nativo do Linux.

### Instalação de dependências backend
```
$ cd laravel-app
$ composer install
```

### Inicialização dos serviços backend
```
$ cd laravel-app
$ ./vendor/bin/sail up -d
```

### Execução **testes** backend
```
$ cd laravel-app
$ ./vendor/bin/sail artisan test
```
