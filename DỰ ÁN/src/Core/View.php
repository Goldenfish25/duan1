<?php

namespace App\Core;

class View
{
    private static string $basePath;

    public static function setBasePath(string $path): void
    {
        self::$basePath = rtrim($path, '/');
    }

    public static function render(string $template, array $data = []): string
    {
        $file = self::$basePath . '/' . str_replace('.', '/', $template) . '.php';

        if (!file_exists($file)) {
            throw new \RuntimeException("View {$template} not found");
        }

        extract($data);
        ob_start();
        require $file;
        return ob_get_clean();
    }
}

