<?php
namespace App\Core;

class Request
{
    private array $get;
    private array $post;
    private array $server;
    private array $cookies;
    private array $files;
    private array $session;

    private function __construct(
        array $get,
        array $post,
        array $server,
        array $cookies,
        array $files,
        array $session
    ) {
        $this->get     = $get;
        $this->post    = $post;
        $this->server  = $server;
        $this->cookies = $cookies;
        $this->files   = $files;
        $this->session = $session;
    }

    public static function fromGlobals(): self
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        return new self(
            $_GET,
            $_POST,
            $_SERVER,
            $_COOKIE,
            $_FILES,
            $_SESSION
        );
    }

    public function method(): string
    {
        return strtoupper($this->server['REQUEST_METHOD'] ?? 'GET');
    }

    public function path(): string
    {
        $uri = $this->server['REQUEST_URI'] ?? '/';
        return parse_url($uri, PHP_URL_PATH);
    }

    public function query(?string $key = null, $default = null)
    {
        if ($key === null) {
            return $this->get;
        }

        return $this->get[$key] ?? $default;
    }

    public function input(?string $key = null, $default = null)
    {
        if ($key === null) {
            return $this->post;
        }

        return $this->post[$key] ?? $default;
    }

    public function all(): array
    {
        return array_merge($this->get, $this->post);
    }

    public function session(string $key, $value = null)
    {
        if ($value === null) {
            return $this->session[$key] ?? null;
        }

        $_SESSION[$key] = $value;
        $this->session[$key] = $value;
    }

    public function has(string $key): bool
    {
        return isset($this->post[$key]) || isset($this->get[$key]);
    }
}
