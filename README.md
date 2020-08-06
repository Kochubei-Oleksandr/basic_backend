<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- [UserInsights](https://userinsights.com)
- [Fragrantica](https://www.fragrantica.com)
- [SOFTonSOFA](https://softonsofa.com/)
- [User10](https://user10.com)
- [Soumettre.fr](https://soumettre.fr/)
- [CodeBrisk](https://codebrisk.com)
- [1Forge](https://1forge.com)
- [TECPRESSO](https://tecpresso.co.jp/)
- [Runtime Converter](http://runtimeconverter.com/)
- [WebL'Agence](https://weblagence.com/)
- [Invoice Ninja](https://www.invoiceninja.com)
- [iMi digital](https://www.imi-digital.de/)
- [Earthlink](https://www.earthlink.ro/)
- [Steadfast Collective](https://steadfastcollective.com/)
- [We Are The Robots Inc.](https://watr.mx/)
- [Understand.io](https://www.understand.io/)
- [Abdel Elrafa](https://abdelelrafa.com)
- [Hyper Host](https://hyper.host)
- [Appoly](https://www.appoly.co.uk)
- [OP.GG](https://op.gg)
- [云软科技](http://www.yunruan.ltd/)

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).


# Stages of creating a structure:
* Проектируем базу данных под требования заказчика и с возможностью исспользовать наши архитектурные решения

____________________________________________________________

1) установка проекта composer create-project --prefer-dist laravel/laravel PROJECT_NAME / конфигурируем .env файл, подключаем БД.
2) введение команды php artisan key:generate
3) добавление базовых роутов
4) добавить Requests (BaseApiRequest, LoginRequest, MessageRequest, RegisterRequest, UserRequest)
5) установить версию php от 7.4 в файле composer.json
6) установить пакет jwt авторизации (composer require tymon/jwt-auth и https://jwt-auth.readthedocs.io/en/docs/laravel-installation/) и настроить его
7) создали базовые контроллеры (BaseController, BaseAuthController) 
8) создали базовые модели и их реализацию в трейтах (CoreBaseModelTrait, BaseModelTrait, BaseModel)
9) создание основных моделей (User, Language)
10) добавление middleware для проекта (JWTAuth, ModifyHeaders, SetLanguage)
11) Создание базовых сервисов (MessageService)
12) RouteServiceProvider -> mapApiRoutes - убираем прификс prefix('api')
13) Создание миграций и сидов со статическими данными бэкенда (languages.sql, CreateLanguagesTable, CreateUsersTable, DatabaseSeeder, LanguagesSeeder)
14) написание тестов API под текущую логику 
15) выполнить composer dump-autoload для подтягивание не индексируемых файлов
16) в $routeMiddleware подключить ('jwt-auth' => JWTAuth::class, 'language' => SetLanguage::class)
17) скоректировать guards в auth.php

Основные правила работы над проектом:
1) Исспользуем существующую архитектуру для проектов компании
2) Особое внимание уделяем таблицам с переводами, базовым моделям и контроллерам
4) Исспользуем техники написания надежного и правильно оформленного кода, ниже основные из них...

Правила для оформления кода:
https://habr.com/ru/company/mailru/blog/336788/
https://laravel.ru/posts/864
https://laravel.ru/posts/147

Руководство по разработке:
1) Пишем API тесты прежде, чем начали реализовывать бизнес логику. На выходе должны получить список входных и выходных данных
2) Пишем реализацию валидаций в Requests под новый контроллер или редактируем старые.
3) Создаем только новые миграции (НЕ изменять старые) и создаем или редактируем сиды.
4) Создаем или редактируем модель данных при необходимости на основании инфы после создания тестов
5) создаем контроллер для выполнения запроса (внутри него только обращение к модели и вывод результата, никакой бизнес логики).
Максимально исспользуем функционал базового контроллера.
6) При необходимости переопределяем функции базовой модели в самой модели, куда поступают данные с контроллера
7) Пишем роуты для взаимодействия с контроллером
8) Выносим всю повторяющуюся или большые куски кода бизнес логики в отдельные сервисы
9) Корректируем тесты при необходимости, тестируем.
