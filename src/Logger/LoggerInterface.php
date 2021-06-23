<?php
namespace LaravelRouteLog\Logger;

interface LoggerInterface {
    public function log(string $method, string $path, string $route_name, $requested_at, $request_length);

    public function clear(\DateTimeInterface $startDate, \DateTimeInterface $endDate);
    public function clearAll();
}