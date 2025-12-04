<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Dev Environment
Laravel Framework 10.50.0

PHP 8.1.33

mysql  Ver 8.0.44-0ubuntu0.24.04.1

NodeJs v24.11.1 / NPM 11.6.2

## Project Setup

Clone the repository: `git clone git@github.com:jcarpizo/project-management-tool.git`

Change Directory: `cd project-management-tool`

Copy the Env file: `cp .env.example .env`

Setup Local Database Credentials: 

```DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=project_management_tool
DB_USERNAME=
DB_PASSWORD=
```

Setup Local Mailer as Log (For the meantime):
```
MAIL_MAILER=log
MAIL_HOST=127.0.0.1
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@example.com"
```

Run the Composer Install: `composer install`

Run the Migration Seeder: `php artisan migrate:fresh --seed`

Run npm Install and build `npm install && npm run build`

Run the Application:  `php artisan serve`

Login Page: http://127.0.0.1:8000/login

Regular User: 
Username: `user@gmail.com` Password: `user123`

Admin User:
Username: `admin@gmail.com` Password: `admin123`

Other Links:
Register: http://127.0.0.1:8000/register

Forgot Password: http://127.0.0.1:8000/forgot-password

## Send Project Deadline Reminder
Run this command line: `php artisan projects:send-deadline-reminders`

## Running PHP Unit Test Cases: 
Run this command line: `php artisan test`

## Reference:
Laravel Breeze;
Laravel Sanctum;
Audit Logs: Using Observer Pattern;
