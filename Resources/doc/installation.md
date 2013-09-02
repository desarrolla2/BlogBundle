# Bundle Installation

## Install Symfony2

This bundle requires Symfony 2.3

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

## Configure your database

If you arent configured your database you need to read symfony database
[documentation] http://symfony.com/doc/current/book/doctrine.html

### Generate database schema

        
And make

``` bash
composer update
```
