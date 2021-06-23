<?php
namespace LaravelRouteLog;

use Illuminate\Container\Container;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use LaravelRouteLog\Commands\ClearRouteLogCommand;
use LaravelRouteLog\Logger\DatabaseLogger;
use LaravelRouteLog\Logger\FileLogger;
use LaravelRouteLog\Logger\LoggerInterface;

class LaravelRouteLogProvider extends ServiceProvider {
    public function register(){
        $this->app->instance(LoggerInterface::class, new DatabaseLogger());
    }

    protected $startTime;

    public function boot(){
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->commands([
            ClearRouteLogCommand::class
        ]);

        if($this->app->runningInConsole()){
            return;
        }

        $this->app->booted(function(){
            $this->startTime = microtime(true);
        });
        $this->app->terminating(function(){
            $totalTime = microtime(true) - $this->startTime;
            $request = request();
            $route = $request->route();

            app(LoggerInterface::class)->log($request->getMethod(), $request->path(), $route->getName(), now(), round($totalTime * 1000, 4));
        });
    }

}