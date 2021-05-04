# Photlog
A simple sharing pictures blog.

## General informations
Goal : Conception of a photo sharing blog

## Installation
1. Clone git repository :
```
$ clone git https://github.com/bricard-dev/photlog.git
```
2. Insert database url configuration in `.env` file.
3. Insert mailer dsn configuration in `.env` file.
4. Insert first admin to `users` table.
5. Start server (with Symfony CLI) : 
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
