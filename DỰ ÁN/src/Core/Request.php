<?php

namespace App\Core;

class Request
{
    private array $routeParams = [];

    public static function capture(): self
    {
        return new self();
    }

    public function method(): string
    {
        return strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
    }

    public function path(): string
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $path = parse_url($path, PHP_URL_PATH);
        return rtrim($path, '/') ?: '/';
    }

    public function input(string $key, mixed $default = null): mixed
    {
        return $_POST[$key] ?? $_GET[$key] ?? $default;
    }

    public function all(): array
    {
        return array_merge($_GET, $_POST);
    }

    public function only(array $keys): array
    {
        $data = [];
        foreach ($keys as $key) {
            $data[$key] = $this->input($key);
        }
        return $data;
    }

    public function setRouteParams(array $params): void
    {
        $this->routeParams = $params;
    }

    public function routeParam(int $index, mixed $default = null): mixed
    {
        return $this->routeParams[$index] ?? $default;
    }
}

