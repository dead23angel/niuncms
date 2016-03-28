<?php

namespace App;

use Illuminate\Cache\CacheManager;
use Illuminate\Config\Repository;
use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Events\Dispatcher;
use Illuminate\Http\Request;
use Illuminate\Redis\Database;
use Illuminate\Routing\Router;

class Core
{
    public static $app = false;

    public function __construct()
    {
        self::$app = new Container();

        self::$app->singleton('config', function () {
            return new Repository(require __DIR__ . '/../config/app.php');
        });

        self::$app->singleton('events', function ($app) {
            return new Dispatcher($app);
        });

        self::$app->bind('files', 'Illuminate\Filesystem\Filesystem');
        self::$app->bind('view', 'App\Classes\View');

        if (config('cache.default') === 'redis') {
            self::$app->singleton('redis', function () {
                return new Database(config('database.redis'));
            });
        }

        self::$app->singleton('cache', function ($app) {
            $cacheManager = new CacheManager($app);
            return $cacheManager->store();
        });
    }

    public function run()
    {
        $this->addConnection();

        self::$app->singleton('router', function () {
            return new Router(app('events'));
        });

        // Load the routes
        require_once __DIR__ . '/../config/routes.php';

        $request = Request::capture();

        $response = app('router')->dispatch($request);

        $response->send();
    }

    /**
     * Set the globally available instance of the container.
     *
     * @return $this->app
     */
    public static function getContainer()
    {
        return static::$app;
    }

    protected function addConnection()
    {
        $capsule = new Manager(app());
        $capsule->addConnection([]);
        
        $capsule->setEventDispatcher(app('events'));
        
        $capsule->setAsGlobal();
        
        $capsule->bootEloquent();
    }
}
