<?php
namespace LaravelRouteLog\Logger;

use Illuminate\Support\Facades\Log;

class FileLogger implements LoggerInterface {
    public function log(string $method, string $path, string $route_name, $requested_at, $request_length)
    {
        Log::info('Log', compact('method', 'path', 'route_name', 'requested_at', 'request_length'));
    }

    public function clear(\DateTimeInterface $startDate, \DateTimeInterface $endDate)
    {
    }

    public function clearAll()
    {
    }
}