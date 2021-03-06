<?php

require_once 'src/controlles/DefaultController.php';
require_once 'src/controlles/SecurityController.php';
require_once 'src/controlles/GameController.php';
require_once 'src/controlles/ExploreController.php';
require_once 'src/controlles/ProfileController.php';
require_once 'src/controlles/RegistrationController.php';
require_once 'src/controlles/RegistrationCompletionController.php';


class Router {

    public static $routes;

    public static function get($url, $controller) {
        self::$routes[$url] = $controller;
    }

    public static function post($url, $controller) {
        self::$routes[$url] = $controller;
    }

    public static function run ($url) {
        $action = explode("/", $url)[0];
        if (!array_key_exists($action, self::$routes)) {
            die("Wrong url!");
        }

        $controller = self::$routes[$action];
        $controllerObject = new $controller;
        $action = $action ?: 'index';

        $controllerObject->$action();
    }
}