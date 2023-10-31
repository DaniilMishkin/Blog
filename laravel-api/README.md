# laravel-api

## Technologies
Project is created with:
* PHP 8.2.1
* Laravel 9.46.0
* Composer

## To use the application, you need to install MySQL on your device.
```sh
https://www.mysql.com/
```

## Move to project directory
```
cd laravel-api 
```

## Install dependencies 
```
composer install
```

## Create a configuration .env file
```
cp .env.example .env
```

## Create tables in the database.
```
php artisan migrate
```

## Compiles for development
```
php artisan serve
```

## Lints and fixes files
```
./vendor/bin/pint
```

## To use real-time 

### Run laravel-echo-server
```
laravel-echo-server start
```

### Run queues 
```
php artisan queue:work
```
