<?php

class AppController
{

    private $request;

    public function __construct()
    {
        $this->request = $_SERVER['REQUEST_METHOD'];
    }

    protected function isGet(): bool
    {
        return $this->request === 'GET';
    }

    protected function isPost(): bool
    {
        return $this->request === 'POST';
    }

    protected function render(string $page = null, array $variables = [])
    {
        $templatePath = 'public/views/'. $page .'.php';
        $output = 'File not found';

        if(file_exists($templatePath))
        {
            extract($variables,0);

            ob_start();
            include $templatePath;
            $output = ob_get_clean();
        }
        print $output;
    }
}