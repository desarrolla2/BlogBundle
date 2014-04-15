# Bundle Installation

## Prerequisites

This version of the bundle requires Symfony 2.3.

// PUT HERE RESUME LIST

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

run composer update

``` bash
$ composer update --no-custom-installers --no-scripts --verbose
```

## Enable the Bundle

Enable the blog bundle in your AppKernel, additionally you need to enable KnpPaginatorBundle.

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
        new Gregwar\CaptchaBundle\GregwarCaptchaBundle(),
        new Desarrolla2\Bundle\BlogBundle\BlogBundle(),
    );
}
```

## Enable the routing

Enable the routing, you could use another prefix if you want.

``` yml
# app/config/routing.yml

blog-admin:
    resource: "@BlogBundle/Controller/Backend/"
    type:     annotation
    prefix:   /admin

blog:
    resource: "@BlogBundle/Controller/Frontend/"
    type:     annotation
    prefix:   /

```

## Configure your application security

You need protect your admin Area, you could use your own system, so this is the most simple example for this.

``` yml
# app/config/security.yml
    providers:
        in_memory:
            memory:
                users:
                    admin: { password: admin, roles: [ 'ROLE_ADMIN' ] }

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

## Update your database schema

### Configure your database

Fist, if you aren't configured your database you need to read symfony database
[documentation](http://symfony.com/doc/current/book/doctrine.html).

Your parameters should looks like this.

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

### Update schema

Now that the bundle is configured, the last thing you need to do is update your database schema.

run following command.

``` bash
$ php doctrine:schema:update --dump-sql
```

It will show the changes that will be made ​​in the database, if everything is correct then you can execute.

``` bash
$ php doctrine:schema:update --force
```

# Create your base templates

*We are ending, Let's go!*

Templates from blog bundle extends from tho templates:

* "::frontend.html.twig"
* "::backend.html.twig"

You need to create your templates as following

``` twig
# app/Resources/views/frontend.html.twig
{% extends "BlogBundle::frontend.html.twig" %}
[...]
```

``` twig
# app/Resources/views/backend.html.twig
{% extends "BlogBundle::backend.html.twig" %}
[...]
```

You can to override templates or blocks of blog bundle here.

#Configure locale

``` yml
twig:
    globals:
        env: "%kernel.environment%"
        locale: 'en'
```

#Last step Assetic Configuration

One last thing, you must add blog bundle to the assetic bundle configuration

``` yml
assetic:
    # [...]
    bundles:        [ BlogBundle ]
```

*Good Look with your blog*


