# DGT Farm Project

### Prerequisites
* Docker

### Installing

* Clone project to your local

```
git clone https://github.com/ppraserts/gom.git
```

* Go to directory

```
cd gom
```

* Install Laravel Package via Docker

```
docker run --rm -v $(pwd)/laravel:/app composer/composer install
```

* Change file ./laravel/.env.example to ./laravel/.env

* Start your project

```
docker-compose up
```

* Remove your container project

```
docker-compose down
```

## Running your website

Open browser: http://localhost

## Running your phpMyAdmin

Open browser: http://localhost:8081
Username: root
Password: gom

## Restore your database backup

Use backup file: onlinemarkets.sql import via phpMyAdmin

## Migration Data & New Controller

* docker-compose exec app php laravel/artisan migrate --seed
* docker-compose exec app php laravel/artisan make:controller MyController

## Clean Docker-compose

* docker system prune
* docker volume prune
