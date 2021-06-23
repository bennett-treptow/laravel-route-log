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
        $this->app->singleton(LoggerInterface::class, function(){
            $driver = [
                'file' => FileLogger::class,
                'database' => DatabaseLogger::class
            ][config('laravel-route-log.driver')];

            return new $driver();
        });
    }

    protected $startTime;

    public function boot(){
        $this->commands([
            ClearRouteLogCommand::class
        ]);
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-route-log.php', 'laravel-route-log');

        if(config('laravel-route-log.enabled')) {
            $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
            if ($this->app->runningInConsole()) {
                return;
            }

            $this->app->booted(function () {
                $this->startTime = microtime(true);
            });
            $this->app->terminating(function () {
                $totalTime = microtime(true) - $this->startTime;
                $request = request();
                $route = $request->route();

                app(LoggerInterface::class)->log($request->getMethod(), $request->path(), $route->getName(), now(),
                    round($totalTime * 1000, 4));
            });
        }
    }

}