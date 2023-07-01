# CodeIgniter 4 - CRUD

## Requirements

- Docker
- Docker Compose

## Technologies used
- PHP 8.2
- MySQL 8.0
- CodeIgniter v4.3.6
- CodeIgniter/Shield v1.0.0-beta.6

## Setup
1. `cp env .env`
2. `docker-compose build`
3. `docker-compose up -d`
4. `docker-compose exec app /bin/sh`
5. `composer install`
6. `php spark migrate --all`
7. Access [http://localhost:8000](http://localhost:8000)

## Run Feature Tests
1. `docker-compose up -d`
2. `docker-compose exec app /bin/sh`
3. `composer test`