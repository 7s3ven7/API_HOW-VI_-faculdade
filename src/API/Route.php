<?php

namespace src\API;

class Route
{

    public string $class;
    public string $function;
    public string $url;
    public string $method;

    public function __construct(string $class, string $function, string $url, string $method = 'GET')
    {
        $this->class = $class;
        $this->function = $function;
        $this->url = $url;
        $this->method = $method;
    }

    public function getBody(): array
    {
        return json_decode(file_get_contents('php://input'), true) ?? [];
    }

    public function returnResponse($response): void
    {
        if (is_array($response) || is_object($response) || is_int($response)) {
            print_r(json_encode($response));
        } else {
            print_r($response);
        }
    }

    public function routeEquals($url): bool
    {

        $pattern = preg_replace(
            '/\{[a-zA-Z_][a-zA-Z0-9_]*\}/',
            '[^/]+',
            $this->url
        );

        return preg_match("#^$pattern$#", $url) === 1;
    }

    public function match(string $url): bool|array
    {
        $pattern = preg_replace(
            '/\{(\w+)\}/',
            '(?P<$1>[^/]+)',
            $this->url
        );
        $pattern = "#^$pattern$#";

        if (preg_match($pattern, $url, $matches)) {

            return array_filter($matches, function ($key) {
                return !is_int($key);
            }, ARRAY_FILTER_USE_KEY);

        }

        return false;
    }

    public function execute(string $url = ''): void
    {
        $body = $this->getBody() ?? [];
        $urlParams = $this->match($url) ?? [];
        $newClass = new $this->class();
        $response = [];

        if (!empty($body)) {

            switch ($this->method) {
                case 'POST':
                    $response = $newClass->{$this->function}(body: $body);
                    break;
                case 'PUT':
                    $response = $newClass->{$this->function}(body: $body, urlParams: $urlParams);
                    break;
                case 'PATCH':
                    $newClass->{$this->function}(body: $body, urlParams: $urlParams);
                    break;
            }
        } else {

            if (!empty($urlParams)) {
                $response = $newClass->{$this->function}(urlParams: $urlParams);
            } else {
                $response = $newClass->{$this->function}();
            }
        }

        $this->returnResponse($response);
    }
}