# BlogBundle

This is the most complete bundle you can find to start creating your blog, 
actualy this blogBundle is running on Symfony2.3

Some Features include:

* URLs SEO friendly
* Taxonomy with Many to Many relation to post
* Article editing with awasome theme for ckEditor
* Very basic image upload and management
* Comments management
* Blog archive
* HTTP cache support

You can see a example for this blog in http://desarrolla2.com

## Bundle Installation

### Get the bundle

Add to your `/composer.json` file :

``` json
    "require": {
        ...       
        "desarrolla2/rss-client-bundle": "dev-master" 
    },
````
        
And make

``` bash
composer update
```

### Register the bundle

``` php
<?php

  // app/AppKernel.php
  public function registerBundles()
  {
    return array(
      // ...
      new Desarrolla2\Bundle\RSSClientBundle\RSSClientBundle(),
      );
  }
```

### Add routes

In your routing.yml you need to publish Backend and Frontend in your prefered paths

``` yml
BlogBundleAdmin:
    resource: "@BlogBundle/Controller/Backend/"
    type:     annotation
    prefix:   /admin      
    
BlogBundle:
    resource: "@BlogBundle/Controller/Frontend/"
    type:     annotation
    prefix:   /    
```

Setting variables

You need to add something like this in your config.yml

``` yml
blog:
  title: 'Técnicas trucos y curiosidades de desarrollo de software.'
  description: 'Noticias y novedades sobre el mundo de la tecnología, Symfony2, php, javascript, linux y otros ...'
  items: 12
  sitemap:
    items: 50
  rss:
    name: 'Desarrolla2'
    items: 16  
```


## Using the bundle

Not ready yet :(, contributions here is apreciated.

## Coming soon

* Improve Comments workflow.
* Social networks integration.
* Search integration
* Pingbaks
* More documentation
* Some tests

## Contact

You can contact with me on [twitter](https://twitter.com/desarrolla2).
