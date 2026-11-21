<?php
declare(strict_types=1);
namespace App\Core;

final class View
{
    public static function render(string $view, array $data = [], string $layout = 'layouts/main'): void
    {
        extract($data, EXTR_SKIP);
        $pageScripts = '';

        $level = ob_get_level();
        ob_start();
        require BASE_PATH . "/views/{$view}.php";
        $content = ob_get_clean();

        while (ob_get_level() > $level) {
            ob_end_clean();
        }

        require BASE_PATH . "/views/{$layout}.php";
    }
}