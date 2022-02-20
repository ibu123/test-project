# Vittor Practical

### steps to setup - in localhost

```sh
git clone https://github.com/ibu123/test-project.git
composer i
cp .env-example .env
```

- Set Databse details
- MAIL settings.
- Application URL

### Type following commnad

```
php artisan key:generate
php artisan migrate
php artisan db:seed - to add admin directly
php artisan storage:link

```
admin
user name :- admin
password :- admin

please do admin login before call send invitation API.
