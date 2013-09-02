# Bundle Installation

## Prerequisites

This version of the bundle requires Symfony 2.3.

## Install Symfony

If you are starting a new project you need install symfony standard, if you already 
have a symfony project go to next step.

If you arent install symfony yet you need to read symfony install
[documentation](http://symfony.com/doc/current/book/installation.html)

## Install the bundle

Add to your `/composer.json` file :

``` json
    "require": {
        ...
        "desarrolla2/blog-bundle": "dev-master"
    },
````

*If you are in production environment, maybe you want to fix version.*

## Enable the Bundle

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Desarrolla2\Bundle\BlogBundle\BlogBundle(),
    );
}
```

## Enable the routing

Enable the routing

``` yml
# app/config/routing.yml

BlogBundleAdmin:
    resource: "@BlogBundle/Controller/Backend/"
    type:     annotation
    prefix:   /admin

BlogBundle:
    resource: "@BlogBundle/Controller/Frontend/"
    type:     annotation
    prefix:   /

```

## Configure your application security

``` yml
# app/config/security.yml
    providers:
        in_memory:
            memory:
                users:
                    admin: { password: adminpass, roles: [ 'ROLE_ADMIN' ] }

# [..]
    firewalls:
        dev:
            pattern:  ^/(_(profiler|wdt)|css|images|js)/
            security: false

        login:
            pattern:  ^/admin/login$
            security: false

        secured_area:
            pattern:    ^/admin/
            form_login:
                check_path: /admin/login_check
                login_path: /admin/login
                always_use_default_target_path: true
                default_target_path: /admin/
            logout:
                path:   /admin/logout
                target: /
            anonymous: ~

            remember_me:
                key: ThisTokenIsNotSoSecretChangeIt
                lifetime: 1800
                path: /.*

```

## Configure your database

If you arent configured your database you need to read symfony database
[documentation] http://symfony.com/doc/current/book/doctrine.html

``` yml
# app/config/parameters.yml
parameters:
    database_driver: pdo_mysql
    database_host: 127.0.0.1
    database_port: null
    database_name: blog_bundle_dev
    database_user: myUser
    database_password: myPass
    locale: en
    secret: ThisTokenIsNotSoSecretChangeIt
```

### Generate database schema

```
php doctrine:schema:update --force
```



        
And make

``` bash
composer update
```
