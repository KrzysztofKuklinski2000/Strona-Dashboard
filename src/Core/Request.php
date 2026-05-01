<?php
declare(strict_types=1);

namespace App\Core;

class Request
{
    private array $routeParams = [];

    public function __construct(
        private readonly array $get,
        private readonly array $post,
        private readonly array $server,
        private array          $session)
    {
    }

    public function getSession(string $param, $default = null): mixed
    {
        return $this->session[$param] ?? $default;
    }

    public function setSession(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
        $this->session[$key] = $value;
    }

    public function removeSession(string $key): void
    {
        unset($_SESSION[$key]);
        unset($this->session[$key]);
    }

    public function getQueryParam(string $name, $default = null): mixed
    {
        return $this->get[$name] ?? $default;
    }

    public function getFormParam(string $name, $default = null): mixed
    {
        return $this->post[$name] ?? $default;
    }

    public function getServerParam(string $key, $default = null): mixed
    {
        return $this->server[$key] ?? $default;
    }

    public function getFile(string $name, $default = null): mixed {
        return $_FILES[$name] ?? $default;
    }

    public function getMethod(): string
    {
        return $this->server['REQUEST_METHOD'] ?? 'GET';
    }

    public function isPost(): bool
    {
        return $this->getMethod() === 'POST';
    }

    public function hasPost(): bool
    {
        return !empty($this->post);
    }

    public function setRouteParams(array $params): void
    {
        $this->routeParams = $params;
    }

    public function getRouteParam(string $key, $default = null): mixed
    {
        return $this->routeParams[$key] ?? $default;
    }
}