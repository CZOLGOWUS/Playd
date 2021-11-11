<?php

class Router
{
    public static function run(?string $uri)
    {
        $controller = new DashboardController();
        if($uri === 'login')
        {
            //open login page
            $controller->login();
        }
        if($uri === 'dashboard')
        {
            //open dashboard page
            $controller->dashboard();
        }
    }
}