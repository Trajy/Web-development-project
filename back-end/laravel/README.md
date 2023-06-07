<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Sobre o Laravel

Laravel é um framework de aplicações web com sintaxe expressiva e elegante. Acreditamos que o desenvolvimento deve ser uma experiência agradável e criativa para ser verdadeiramente gratificante. O Laravel simplifica o desenvolvimento facilitando tarefas comuns usadas em muitos projetos da web, como:

- [Mecanismo de roteamento simples e rápido](https://laravel.com/docs/routing).
- [Poderoso contêiner de injeção de dependência](https://laravel.com/docs/container).
- Múltiplos back-ends para [sessão](https://laravel.com/docs/session) e armazenamento de [cache](https://laravel.com/docs/cache).
- Expressivo, intuitivo [ORM](https://laravel.com/docs/eloquent).
- [Migrações de esquema agnóstico de banco de dados](https://laravel.com/docs/migrations).
- [Processamento robusto de trabalhos em segundo plano](https://laravel.com/docs/queues).
- [Transmissão de eventos em tempo real](https://laravel.com/docs/broadcasting).

O Laravel é acessível, poderoso e fornece as ferramentas necessárias para aplicativos grandes e robustos.

## Aprendendo Laravel

O Laravel possui a [documentação](https://laravel.com/docs) mais extensa e completa e a biblioteca de tutoriais em vídeo de todos os frameworks de aplicativos da web modernos, tornando fácil começar a usar o framework.

Você também pode experimentar o [Laravel Bootcamp](https://bootcamp.laravel.com), onde será guiado na construção de um aplicativo Laravel moderno do zero


Se você não gosta de ler, [Laracasts](https://laracasts.com) pode ajudar. Laracasts contém mais de 2.000 tutoriais em vídeo sobre uma variedade de tópicos, incluindo Laravel, PHP moderno, teste de unidade e JavaScript. Aumente suas habilidades explorando nossa abrangente biblioteca de vídeos.

## Contribuindo

Obrigado por considerar contribuir com o framework Laravel! O guia de contribuição pode ser encontrado na [documentação Laravel](https://laravel.com/docs/contributions).

## Código de Conduta

Para garantir que a comunidade Laravel seja acolhedora para todos, por favor, revise e cumpra o [Código de Conduta](https://laravel.com/docs/contributions#code-of-conduct).

## Vulnerabilidades de segurança

Se você descobrir uma vulnerabilidade de segurança no Laravel, envie um e-mail para [taylor@laravel.com](mailto:taylor@laravel.com). Todas as vulnerabilidades de segurança serão prontamente abordadas.

## License

O framework Laravel é um software de código aberto licenciado sob a [licença MIT](https://opensource.org/licenses/MIT).

#
# Preparando a aplicação

* Certifique-se que o banco de dados esteja em execução

* Ao clonar o repositorio navegue ate o diretorio `back-end/laravel`, para navegar entre diretorios utilize
    ```bash
    cd <caminho-do-diretorio-do-projeto>
    ```

## Download de dependencias
* instale as dependencias do projeto utilizando o [`composer`](https://getcomposer.org/)
    ```bash
    composer install
    ```

## Estruturando banco de dados
* para criar as tabelas no banco de dados.
    ```bash
    php artisan migrate
    ```

* para popular as tabelas no banco de dados.
    ```bash
    php artisan db:seed --class=DataBaseSeeder
    ```

## Executando a aplicação

* inicie a aplicacao
    ```bash
    php artisan serve
    ```

## Documentação dos end-points
 A documentação dos end-points foi desenvolvida utilizando o [swagger](https://swagger.io/specification) pode ser acessada localmente em http://127.0.0.1/api-documentation/index.html

