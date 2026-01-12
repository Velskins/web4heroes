<?php
declare(strict_types=1);

namespace App\Core;

final class View
{
    public static function render(string $template, array $data = []): string
    {
        $viewsDir = dirname(__DIR__) . '/../views';
        $viewFile = $viewsDir . '/' . $template . '.php';
        $layout   = $viewsDir . '/../layout.php';

        if (!file_exists($viewFile)) {
            return "View introuvable: {$template}";
        }

        extract($data, EXTR_SKIP);

        ob_start();
        if (file_exists($layout)) {
            $view = $viewFile;
            require $layout;
        } else {
            require $viewFile;
        }
        return (string)ob_get_clean();
    }
}
