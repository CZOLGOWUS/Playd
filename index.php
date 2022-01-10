<?php

require_once "Router.php";

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url( $path, PHP_URL_PATH);

Router::get('', 'DefaultController');
Router::get('indexPage', 'DefaultController');
Router::get('explore', 'DefaultController');
Router::get('preferencesSurvey', 'DefaultController');
Router::get('contact', 'DefaultController');

Router::post('login', 'SecurityController');

Router::post('addGame', 'GamePageController');
Router::get('gamePage', 'GamePageController');

Router::get('explore','ExploreController');

Router::get('profile','ProfileController');


Router::run($path);