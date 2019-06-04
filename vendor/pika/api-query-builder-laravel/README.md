# API Query Builder Package For Laravel & Lumen

#### Firstly, edit your composer.json file:

    "require": {
        "pika/api-query-builder-laravel": "~1.0"
    }

Then, run this command on the terminal

`composer update`
#### Service Provider
For Laravel:

Add this line into `config/app.php` file's providers

    'Pika\Api\ApiQueryBuilderServiceProvider',

For Lumen:
Add these lines into `bootstrap/app.php`

    $app->withFacades();
    $app->withEloquent();
    $app->register(Pika\Api\LumenServiceProvider::class);
### Configuration File
##### If you use Lumen please skip this step

If you want to change default limit, orderBy and excludedParameters parameters, run this command on the terminal:

`php artisan vendor:publish --provider="Pika\Api\ApiQueryBuilderServiceProvider"`


Gallery copy from library https://github.com/selahattinunlu/laravel-api-query-builder.

Since the library does not update. Any questions mailed to longvan1296@gmail.com.om.