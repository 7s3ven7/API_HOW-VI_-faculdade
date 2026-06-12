<?php

namespace src\API;

include "Route.php";

const GET = 'GET';
const POST = 'POST';
const PUT = 'PUT';
const PATCH = 'PATCH';
const DELETE = 'DELETE';

class Router
{

    private string $url;
    private string $method;

    private array $routes;

    public function __construct()
    {
        $this->url = $_SERVER['REQUEST_URI'];
        $this->method = $_SERVER['REQUEST_METHOD'];
    }

    public function get(string $url, string $class, string $function): void
    {
        $this->routes[] = new Route($class, $function, $url, GET);
    }

    public function post(string $url, string $class, string $function): void
    {
        $this->routes[] = new Route($class, $function, $url, POST);
    }

    public function patch(string $url, string $class, string $function): void
    {
        $this->routes[] = new Route($class, $function, $url, PATCH);
    }

    public function put(string $url, string $class, string $function): void
    {
        $this->routes[] = new Route($class, $function, $url, PUT);
    }

    public function delete(string $url, string $class, string $function): void
    {
        $this->routes[] = new Route($class, $function, $url, DELETE);
    }

    public function startRouter(): void
    {

        Header('Access-Control-Allow-Origin: *');
        Header('content-type: application/json; charset=utf-8');
        foreach ($this->routes as $route) {

            if ($route->routeEquals($this->url) && $route->method == $this->method) {
                $route->execute($this->url);
                return;
            }
        }

        print_r(json_encode(['error' => 'route not exists']));
    }

}