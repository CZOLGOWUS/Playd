<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/User.php';

class RegistrationController extends AppController
{
    
    public function register()
    {
            $this->render('register');
    }
    
}
