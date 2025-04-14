# Yaraku Web Developer Assignment

By Loke Kum Yew

## Requirements

- [Docker](https://docs.docker.com/install)
- [Docker Compose](https://docs.docker.com/compose/install)

## Setup

1. Clone the repository.
2. Start the containers by running `docker-compose up -d` in the project root. There should be three containers: `laravel` (main), `laravel_test` (testing), `mysql` (database).
3. Install the composer packages by running `docker-compose exec laravel composer install`.
4. Access the Laravel instance on `http://localhost` (If there is a "Permission denied" error, run `docker-compose exec laravel chown -R www-data storage`).

## Run Migrations

- For the main application:

```bash
docker-compose exec laravel php artisan migrate
```

- For the testing database:

```bash
docker-compose exec laravel_test php artisan migrate
```

## Seeding Database

- To seed the production databse:

```bash
docker-compose exec laravel php artisan db:seed --class=BookSeeder
```

## Run Tests

To run the tests in the `laravel_test` environment:

```bash
docker-compose exec laravel_test ./vendor/bin/phpunit
```

Note that the changes you make to local files will be automatically reflected in the container.

## Access the Application

Open your browser and navigate to `http://localhost` to access the Laravel application.


## Persistent database

If you want to make sure that the data in the database persists even if the database container is deleted, add a file named `docker-compose.override.yml` in the project root with the following contents.
```
version: "3.7"

services:
  mysql:
    volumes:
    - mysql:/var/lib/mysql

volumes:
  mysql:
```
Then run the following.
```
docker-compose stop \
  && docker-compose rm -f mysql \
  && docker-compose up -d
``` 
