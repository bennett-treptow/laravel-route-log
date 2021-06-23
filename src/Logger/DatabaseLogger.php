<?php
namespace LaravelRouteLog\Logger;

use LaravelRouteLog\Models\RouteLog;

class DatabaseLogger implements LoggerInterface {
    public function log(string $method, string $path, string $route_name, $requested_at)
    {
        RouteLog::create([
            'method' => $method,
            'path' => $path,
            'route_name' => $route_name,
            'requested_at' => $requested_at
        ]);
    }
}