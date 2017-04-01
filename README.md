silex-simple-swagger-provider
======================

[![Build Status](https://travis-ci.org/Basster/silex-simple-swagger-provider.svg?branch=master)](https://travis-ci.org/Basster/silex-simple-swagger-provider) 
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Basster/silex-simple-swagger-provider/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Basster/silex-simple-swagger-provider/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/Basster/silex-simple-swagger-provider/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/Basster/silex-simple-swagger-provider/?branch=master)

[silex-simple-swagger-provider](https://github.com/Basster/silex-simple-swagger-provider) is a silex service provider that
integrates [swagger-php](https://github.com/zircote/swagger-php) (Version 2) into [silex](https://github.com/fabpot/Silex).  This
service provider adds routes for generating and exposing a swagger defintion based on swagger-php annotations.  The
swagger definition can then be used with [swagger-ui](https://github.com/wordnik/swagger-ui).

This library is strongly inspired by Jason Desrosiers [silex-swagger-provider](https://github.com/jdesrosiers/silex-swagger-provider)
but fully rewritten to meet the needs of [swagger-php](https://github.com/zircote/swagger-php) (Version 2)

:warning: For Silex2 and Pimple3 check out the `silex-2` branch :warning:

Installation
------------
Install the silex-swagger-provider using [composer](http://getcomposer.org/).

```bash
composer require basster/silex-simple-swagger-provider:^2.0
```

Parameters
----------
* **swagger.servicePath**: The path to the classes that contain your swagger annotations.
* **swagger.excludePath**: A string path or an array of paths to be excluded when generating annotations.
* **swagger.apiDocPath**: The URI that will be used to access the swagger definition. Defaults to `/api/api-docs`.
* **swagger.cache**: An array of caching options that will be passed to Symfony 2's `Response::setCache` method.

Services
--------
* **swagger**: An instance of `Swagger\Annotations\Swagger`.  It's the already parsed swagger annotation tree.

Registering
-----------
```php
$app->register(new Basster\Silex\Provider\Swagger\SwaggerProvider(), [
    "swagger.servicePath" => __DIR__ . "/path/to/your/api",
]);
```
Usage
-----
The following routes are made available by default
* `GET /api/api-docs`: Get the list of resources

The results of the swagger definition file is not cached internally.  Instead, the routes that are created are designed
to work with an HTTP cache such as a browser cache or reverse proxy.  You can configure how you want to your service
cached using the `swagger.cache` parameter.  By default, no caching will be done.  Read about
[HTTP caching](http://symfony.com/doc/current/book/http_cache.html) in Symfony for more information about how to
customize caching behavior.  The following example will allow the service definition file to be cached for 5 days.

```php
$app["swagger.cache"] = [
    "max_age": "432000", // 5 days in seconds
    "s_maxage": "432000", // 5 days in seconds
    "public": true,
]
```
