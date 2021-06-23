<?php
namespace LaravelRouteLog;

use Illuminate\Container\Container;
use Illuminate\Support\ServiceProvider;
use LaravelRouteLog\Logger\DatabaseLogger;
use LaravelRouteLog\Logger\LoggerInterface;

class LaravelRouteLogProvider extends ServiceProvider {
    public function register(){
        $this->app->instance(LoggerInterface::class, new DatabaseLogger());
    }

    public function boot(){
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        Container::getInstance()->terminating(function(){
            if(app()->runningInConsole()){
                return;
            }
            $request = request();
            $route = $request->route();

            app(LoggerInterface::class)->log($request->getMethod(), $request->path(), $route->getName(), now());
        });
    }

}