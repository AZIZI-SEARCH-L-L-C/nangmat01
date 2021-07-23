<?php

namespace AziziSearchEngineStarter\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \AziziSearchEngineStarter\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \AziziSearchEngineStarter\Http\Middleware\CheckTerrMiddleware::class,
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'admin'      => \AziziSearchEngineStarter\Http\Middleware\Admin::class,
        'adminNotLoggedIn'      => \AziziSearchEngineStarter\Http\Middleware\adminNotLoggedIn::class,
		'installed' => \AziziSearchEngineStarter\Http\Middleware\Installed::class,
        'NotInstalled'=> \AziziSearchEngineStarter\Http\Middleware\notInstalled::class,
        'privateSearch'    => \AziziSearchEngineStarter\Http\Middleware\PrivateSearch::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \AziziSearchEngineStarter\Http\Middleware\RedirectIfAuthenticated::class,
        'loggedIn' => \AziziSearchEngineStarter\Http\Middleware\userLoggedIn::class,
        'users' => \AziziSearchEngineStarter\Http\Middleware\usersSystem::class,
        'advertisements' => \AziziSearchEngineStarter\Http\Middleware\advertisementSystem::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
		'localize'   => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class,
        'localizationRedirect' => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
        'localeSessionRedirect' => \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
		'StartSession' => \Illuminate\Session\Middleware\StartSession::class,
        'ShareErrorsFromSession' =>    \Illuminate\View\Middleware\ShareErrorsFromSession::class,
		'role' => \Zizaco\Entrust\Middleware\EntrustRole::class,
		'permission' => \Zizaco\Entrust\Middleware\EntrustPermission::class,
		'ability' => \Zizaco\Entrust\Middleware\EntrustAbility::class,
		'maintenance' => \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
    ];
}
