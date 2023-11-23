## Repository for FC Zvezda SPB official site

Based above Laravel and VueJS web application. Start procedure

- git clone.
- cd project.
- install all dependencies.
- ```cp .env.example .env```
- ```php artisan key:generate```
- check database credentials to work with
- ```php artisan migrate```.
- add role admin to roles table.
- assign role to fresh registered user to start work within CRM.
- choose the S3 provider (Amazon or Yandex) and provide all credentials.
- check and redefine ```cloud_path``` const in ```resources/js/Pages/Shared/helpers.js```
- check and redefine mailer setting to use with project

