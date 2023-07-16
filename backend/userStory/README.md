##### Nawatech PHP Developer Coding Test
# #Project 1
Website project
[Documentation Database](https://github.com/androjovi/nawatechCodingTest/blob/master/DocumentationDatabase.pdf)
## Installation

this project requires PHP 8 to run
first you must run command to create database
```sh
sql> CREATE DATABASE userstory;
```

Config file .env to modify the database host,username,password and database
default .env settings
```sh
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=userstory
DB_USERNAME=admin
DB_PASSWORD=admin
```

Run migrate and seeder

```sh
php artisan migrate:refresh --seed
```

After all running laravel project

```sh
php artisan serve
```

Open the browser and go to **127.0.0.1:8000** (default port and host)

***If you see the login page, then the application has been successfully executed.***

#### Admin Login
```
email: admin@test.com
password: admin123456789
```
#### User Login
```
email: user@test.com
password: user123456789
```

### Running queue

This project includes a queue process for sending order and login emails. Here's how to run it

```sh
php artisan queue:work
```
---
**Thankyou.**
