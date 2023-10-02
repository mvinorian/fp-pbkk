# How to run the project

## Clone the repository

```sh
git clone https://github.com/mvinorian/pbkk-task-3
```

## Install composer dependency

```sh
composer install
```

## Install npm dependency

```sh
npm install
```

## Copy environment

```sh
cp .env.example .env
```

## Change database in environment

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pbkk
DB_USERNAME=root
DB_PASSWORD=
```

## Generate laravel key

```sh
php artisan key:generate
```

## Migrate database

```sh
php artisan migrate
```

## Run npm

```sh
npm run dev
```

## Run laravel

```sh
php artisan serve
```
