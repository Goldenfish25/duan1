<?php

namespace App\Core;

use App\Services\AuthService;

abstract class Controller
{
    protected AuthService $auth;

    public function __construct()
    {
        $this->auth = new AuthService();
    }

    protected function view(string $template, array $data = []): void
    {
        echo View::render($template, $data);
    }

    protected function redirect(string $path): void
    {
        header('Location: ' . $path);
        exit;
    }

    protected function back(): void
    {
        $ref = $_SERVER['HTTP_REFERER'] ?? '/';
        $this->redirect($ref);
    }
}

