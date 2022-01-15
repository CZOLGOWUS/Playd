<?php

require_once 'AppController.php';

class RegistrationController extends AppController
{
    
    public function register()
    {
        $this->render('register');
    }
    
}
