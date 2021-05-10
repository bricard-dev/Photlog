# Photlog
A simple sharing pictures blog.

## General informations
Goal : Conception of a photo sharing blog

## Demo
![Alt text](/public/images/photlog-v0-demo.png)

## Requirements
* PHP >= 7.2.5
* Composer
* NodeJS

## Installation
(I use Symfony CLI, but if you don't have this, you can replace `symfony console` by `php bin/console` command).

1. Clone git repository :
```
$ git clone https://github.com/bricard-dev/photlog.git
```
2. Insert database url configuration in `.env` file.
3. Insert mailer dsn configuration in `.env` file.
4. Install dependencies with composer and npm :
```
$ composer install
$ npm install
```
5. Build webpack
```
$ npm run build
```
6. Create your database :
```
$ symfony console doctrine:database:create
```
7. Execute migrations :
```
$ symfony console doctrine:migrations:migrate
```
8. Encode your admin password :
```
$ symfony console security:encode-password
```
9. Insert first admin to `users` table (Don't forget to escape password character) :
```
$ symfony console dbal:run-sql "INSERT INTO users (first_name, last_name, username, email, roles, password) \
  VALUES ('YourFirstName', 'YourLastName', 'YourUsername', 'YourMailAdress', '[\"ROLE_ADMIN\"]', \
  'YourEncodePassword')"
```
10. Start server : 
```
$ symfony server:start
```

## Technologies
Languages :
* PHP (https://www.php.net): Version 7.3.11
* Twig (https://twig.symfony.com): Version 3

Framework :
* Symfony (https://symfony.com): Version 5.2.4
* Bootstrap (https://getbootstrap.com): Version 4.6

RDBMS :
* MySQL (https://www.mysql.com): Version 8.0.21

Bundles :
* WebPack Encore (https://github.com/symfony/webpack-encore-bundle): Version 1.11
* StofDoctrineExtensions (https://github.com/stof/StofDoctrineExtensionsBundle): Version 1.6
* VichUploader (https://github.com/dustin10/VichUploaderBundle): Version 1.16
* EasyAdmin (https://github.com/EasyCorp/EasyAdminBundle): Version 3.2
* KnpPaginator (https://github.com/KnpLabs/KnpPaginatorBundle): Version 5.4
* KnpTime (https://github.com/KnpLabs/KnpTimeBundle): Version 1.16
