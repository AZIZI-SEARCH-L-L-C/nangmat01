<?php

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| The first thing we will do is create a new Laravel application instance
| which serves as the "glue" for all the components of Laravel, and is
| the IoC container for the system binding all of the various parts.
|
*/

$app = new Illuminate\Foundation\Application(
    realpath(__DIR__.'/../')
);

/*
|--------------------------------------------------------------------------
| Bind Important Interfaces
|--------------------------------------------------------------------------
|
| Next, we need to bind some important interfaces into the container so
| we will be able to resolve them when needed. The kernels serve the
| incoming requests to this application from both the web and CLI.
|
*/

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    AziziSearchEngineStarter\Http\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    AziziSearchEngineStarter\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    AziziSearchEngineStarter\Exceptions\Handler::class
);

$app->configureMonologUsing(function($monolog) use ($app) {
	$monolog->setName('system');
    $monolog->pushHandler(
        (new Monolog\Handler\RotatingFileHandler($app->storagePath().'/logs/system.log', $app->make('config')->get('app.log_max_files', 5)))->		setFormatter(new Monolog\Formatter\LineFormatter(null, null, true, true))
    );
});

# [START] Add the following block to `bootstrap/app.php`
/*
|--------------------------------------------------------------------------
| Set Storage Path
|--------------------------------------------------------------------------
|
| This script allows you to override the default storage location used by
| the  application.  You may set the APP_STORAGE environment variable
| in your .env file,  if not set the default location will be used
|
*/
$app->useStoragePath(env('APP_STORAGE', base_path() . '/storage'));
# [END]

/*
|--------------------------------------------------------------------------
| Return The Application
|--------------------------------------------------------------------------
|
| This script returns the application instance. The instance is given to
| the calling script so we can separate the building of the instances
| from the actual running of the application and sending responses.
|
*/

return $app;
