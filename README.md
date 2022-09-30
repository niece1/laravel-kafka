![GitHub language count](https://img.shields.io/github/languages/count/niece1/laravel-kafka-queue)
![GitHub top language](https://img.shields.io/github/languages/top/niece1/laravel-kafka-queue)
![GitHub repo size](https://img.shields.io/github/repo-size/niece1/laravel-kafka-queue)
![GitHub contributors](https://img.shields.io/github/contributors/niece1/laravel-kafka-queue)
![GitHub last commit](https://img.shields.io/github/last-commit/niece1/laravel-kafka-queue)
![GitHub](https://img.shields.io/github/license/niece1/laravel-kafka-queue)

## Intro

Kafka queue for Laravel framework. Created for personal use.

## Usage

Because this package isn't published on Packagist to install it into your Laravel project, follow the steps below:

In your composer.json file under require directive add:
```
"niece1/laravel-kafka-queue": "dev-main"
```

It should look like this:
```
"require": {
	"php": "7.3|8.0",
	**"niece1/laravel-kafka-queue": "dev-main",**
	"laravel/framework": "^9.31"
},
```
Also ypu need to add repositories directive:
```
repositories: [
    {
    	"type": "vcs",
    	"url": "https://github.com/niece1/laravel-kafka-queue.git"
    }
],
```
And run command:
```
composer update
```

The package will be installed into your project.

Add the following at /config/app.php under application service providers:
```
\Kafka\KafkaServiceProvider::class
```

To recognize namespace add appropriate entry:
```
"autoload": {
	"psr-4": {
    	"Kafka\\": "vendor/niece1/laravel-kafka-queue/src"
    }
},
```

and run: composer dump-autoload

To run the queue:
```
php artisan queue:work
```

## License

This is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
