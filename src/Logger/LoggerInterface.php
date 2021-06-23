<?php
namespace LaravelRouteLog\Logger;

interface LoggerInterface {
    public function log(string $method, string $path, string $route_name, $requested_at);
}