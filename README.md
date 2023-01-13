# itQuelle Simple MVC PHP Framework

## Requirements
PHP >=8.x 
Composer

## Tested on 
PHP 8.0.0 Apache

## Installation
```
git clone https://github.com/itquelle/itquelleframework.git
```
Or download the package from [Github](https://github.com/itquelle/itquelleframework).

Then:
1. Install a web server (e.g. Apache), with at least PHP 8.x
2. Open the config file "/config/config.php", and set your settings, such as the app root setting or, if used, your database settings
3. Make sure your Apache web server is started, and open a web browser
4. Open the index page, in most cases with an offline web server you can access this through "localhost", if you are using a subdirectory, include it, and make sure that the subdirectory has been set in the app config.

## Controller template
```
/config/make_controller.txt
```

## Use Console
##### Use console.php only for development
### Create Controller
```php console.php make:controller TestController```
