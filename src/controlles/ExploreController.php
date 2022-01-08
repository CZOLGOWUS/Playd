<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../models/Game.php';

class ExploreController extends AppController
{
    private array $preferences;

    public function explore()
    {

        $this->render('explore');
    }

}