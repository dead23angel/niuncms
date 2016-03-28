<?php

namespace App;

use Illuminate\Cache\CacheManager;
use Illuminate\Config\Repository;
use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Http\Request;
use Illuminate\Redis\Database;
use Illuminate\Routing\Router;

class Core
{
    public static $app = false;

    public static function run() {
        self::$app = new Container();

        self::$app->singleton('config', function () {
            return new Repository(require __DIR__ . '/../config/app.php');
        });

        self::$app->singleton('events', function ($app) {
            return new Dispatcher($app);
        });

        self::$app->singleton('router', function ($app) {
            return new Router($app->make('events'));
        });

        self::$app->bind('files', 'Illuminate\Filesystem\Filesystem');
        self::$app->bind('view', 'App\Classes\View');

        if (self::$app->make('config')->get('cache.default') === 'redis') {
            self::$app->singleton('redis', function ($app) {
                return new Database($app->make('config')->get('cache.database.redis'));
            });
        }

        self::$app->singleton('cache', function ($app) {
            $cacheManager = new CacheManager($app);
            return $cacheManager->store();
        });

        // Load the routes
        require_once __DIR__ . '/../config/routes.php';

        // Create a request from server variables
        $request = Request::capture();

        // Dispatch the request through the router
        $response = self::$app->make('router')->dispatch($request);

        // Send the response back to the browser
        $response->send();
    }
}
