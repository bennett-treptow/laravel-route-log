<?php
namespace LaravelRouteLog\Logger;

use LaravelRouteLog\Models\RouteLog;

class DatabaseLogger implements LoggerInterface {
    public function log(string $method, string $path, string $route_name, $requested_at, $request_length)
    {
        RouteLog::create([
            'method' => $method,
            'path' => $path,
            'route_name' => $route_name,
            'requested_at' => $requested_at,
            'request_length' => $request_length
        ]);
    }

    public function clear(\DateTimeInterface $startDate, \DateTimeInterface $endDate)
    {
        RouteLog::forPeriod($startDate, $endDate)->delete();
    }

    public function clearAll()
    {
        RouteLog::truncate();
    }
}