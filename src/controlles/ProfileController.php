<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/User.php';

class ProfileController extends AppController
{
    
    public function profile()
    {
        $this->render("profile");
    }
    
}
