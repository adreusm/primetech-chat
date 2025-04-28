<?php

namespace App;

class View 
{
    const TEMPLATE_DIR = APP_DIR . '/templates';

    public function __construct(private readonly string $template)
    {}

    public function render(array $data = []): string 
    {
        ob_start();
        $this->includeTemplate($this->template, $data);
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }

    public static function includeTemplate(string $template, array $data = []): void 
    {
        extract($data);
        include self::TEMPLATE_DIR . '/' . ltrim($template, '/');
    }
}
