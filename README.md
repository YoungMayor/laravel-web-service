# Very short description of the package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/youngmayor/web-service.svg?style=flat-square)](https://packagist.org/packages/youngmayor/web-service)
[![Total Downloads](https://img.shields.io/packagist/dt/youngmayor/web-service.svg?style=flat-square)](https://packagist.org/packages/youngmayor/web-service)
![GitHub Actions](https://github.com/youngmayor/laravel-web-service/actions/workflows/main.yml/badge.svg)

A laravel package built as a wrapper around Guzzle for connections to external services/APIs

## Installation

You can install the package via composer:

```bash
composer require youngmayor/web-service
```

## Usage
The package uses auto discovery hence if you use Laravel 5.5 or above, installing the package automatically registers it in your application. 

However, if you use Laravel 5.4 or below you will need to add the below snipet to your `config/app.php` to register the Service Provider
```php
'providers' => [
    ...
    YoungMayor\WebService\WebServiceServiceProvider,
    ...
],
```

Next create your Service class to extend the WebService class 
```php
<?php

namespace App\Services;

use YoungMayor\WebService\WebService;

class MyExampleService extends WebService
{
    /**
    * The baseUri for the service. 
    * This is an important method that must be implemented when extending the WebService Class
    *
    * @return string
    */
    public function baseUri()
    {
        return "https://example.com";
    }
    // ...
}
```
> Your service can seat anywhere on your application. The above is just an example

Then you can add your methods to perform actions. The WebService exposes the following methods
```php 
get($path, $options);
post($path, $options);
put($path, $options);
delete($path, $options);
patch($path, $options);
```
The path is the relative path we would want to call and the options are [Guzzle Request Options](https://docs.guzzlephp.org/en/stable/request-options.html)

## Setting Default Headers
It is possible to apply default headers to every request . Example
```php
...
protected $headers = [
    'Accept' => 'application/json'
]
```
This can be also be achieved by calling the ```setHeaders($headers)``` method on the construct
```php 
...
public function __construct()
{
    parent::__construct(); 

    // $bearerToken = ...;
    $this->setHeaders([
        "Content-Type" => "application/json", 
        "Authorization" => "Basic {$bearerToken}"
    ]);
}
```


### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email youngmayor.dev@gmail.com instead of using the issue tracker.

## Credits

-   [Meyoron Aghogho](https://github.com/youngmayor)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
