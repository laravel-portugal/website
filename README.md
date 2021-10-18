# Laravel Portugal 🇵🇹

[![GitHub Tests Action Status](https://github.com/laravel-portugal/website/actions/workflows/run-tests.yml/badge.svg)](https://github.com/laravel-portugal/website/actions/workflows/run-tests.yml)
[![GitHub Code Style Action Status](https://github.com/laravel-portugal/website/actions/workflows/php-cs-fixer.yml/badge.svg)](https://github.com/laravel-portugal/website/actions/workflows/php-cs-fixer.yml)
[![Website Deployment](https://github.com/laravel-portugal/website/actions/workflows/deploy.yml/badge.svg)](https://github.com/laravel-portugal/website/actions/workflows/deploy.yml)

This repo will be used to develop & maintain the current website for the Laravel community in Portugal, the project is inspired
on Laravel.io, other community repos and of course our loved contributors from the Portuguese community.
The website aims to be a central repository for useful tips, tricks, & more content in the future aiming to help the Portuguese
developers around the world!

## Features

This project is currently using Laravel 8 with Jetstream + Teams scaffolding with Inertia Stack.
You can find here some cool way to implement features or even start your next big thing, some features include:

- Tailwind + Vue3 Components 🍃
- Docker Deployment 🐳
- Github Actions 🤖
- Permissions with Spatie + Inertia
- Translations with Vue i18n + Laravel 🈯
- Crawling & Scrapping with Browsershot
- Usage of Actions & Best Pratices
- Testing using Pest 💘

## Requirements
- PHP 8.0.x
- MYSQL/MariaDB
- Chromium/Puppeteer

## Basic Installation & Setup

This project has no special requirements besides [Browsershot](https://github.com/spatie/browsershot), take it as a vanilla Laravel + Jetstream setup

```bash
git clone https://github.com/laravel-portugal/website.git laravelpt
cd laravelpt
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate
npm install && npm run dev
php artisan storage:link
php artisan:serve
```

## Using Docker

It's also possible to use 🐳 Docker to setup & install the project please kindly follow the instructions:
At this point we assume you have docker & running on your machine

```bash
git clone https://github.com/laravel-portugal/website.git laravelpt
cd laravelpt
cp .env.example .env
cp docker-compose.override.local.yml docker-compose.override.yml
docker-compose build
docker-compose run --rm website composer install --no-interaction
docker-compose run --rm website php artisan key:generate
docker-compose run --rm website npm install
docker-compose run --rm website npm run dev
docker-compose run --rm website php artisan storage:link
docker-compose up -d
docker-compose exec website php artisan migrate
```

To then execute command please kindly use :
```
docker-compose exec website bash
```

If all goes well your new shiny website should be serving at ``http://localhost:800``, enjoy and happy coding 🎉 !

## Setup Browser Shot

Please kindly refer to official [Browsershot](https://github.com/spatie/browsershot) documentation for more issues
The setup should be simple as bellow, please keep in mind updating your .env file with the Node and NPM binaries if you are using NVM or similar.


For Mac OS
```
npm install puppeteer
```

Or Globally
```
npm install puppeteer --global
```

## Compile & Publish Assets

Compiling & Publishing assets are done via [Lasso](https://github.com/Sammyjo20/Lasso).
Please refer to Lasso official documentation.

Publish the assets: 
```bash
php artisan lasso:publish
```

Pull the assets on your deployment script:
```bash
php artisan lasso:pull
```

## Testing

Testing is done via [Pest](https://pestphp.com/)

```bash
pest
```

## Quick Todos 🥵

- [ ] Move Standard Queries to Query Builders to avoid code duplication
- [ ] Ensure the DTOS are excluding non-user data from the update
- [ ] Write more unit tests
- [ ] Create Administration Area to Manage Tags
- [ ] Delete Tags & Links & Perform their needed cleanup
- [ ] Create Administration to Manage Users
- [ ] Add Contributors Avatars Automatically to Homepage
- [ ] Move more static Text to Translation Keys
- [ ] Translate to Portuguese :()
- [ ] Create Landing Page to Search Links
- [ ] Create Public Author Page
- [ ] Create Public Tags Page ( FilterBy )
- [ ] Create Redirects & Test them
- [ ] Implement Websockets
- [ ] Queue all Updates/Actions
 
## Credits
This project is a merge of a previous [Laravel Portugal Api](https://github.com/laravel-portugal/api)
and [Laravel Portugal Frontend project](https://github.com/laravel-portugal/frontend-2020), that then were
merged into the current repo. Many thanks to all contributors!

- [Alexandre Reis](https://github.com/adevr)
- [Ana Lisboa](https://github.com/ana-lisboa)
- [Daniel Maciel](https://github.com/dleicam)
- [João Patrício](https://github.com/ijpatricio)
- [Jorge Costa](https://github.com/jorgercosta)
- [José postiga](https://github.com/josepostiga)
- [Pedro Martins](https://github.com/igerslike)
- [Pedro Vasconcelos](https://github.com/pedro-vasconcelos)
- [Tiago Fernandes](https://github.com/tiagof)

## Support

Support by helping the project & sending some code! Or share some love and sponsor tools you use daily! <3

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
