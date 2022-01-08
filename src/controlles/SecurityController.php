<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/User.php';

class SecurityController extends AppController
{
    public function login()
    {
        $user = new User('user0','email0@email.com','pass0');

        if (!$this->isPost()) {
            $this->render('login');
            return;
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

        if ($user->getEmail() !== $email) {
            $this->render('login', ['messages' => ['User with this email not exist!']]);
            return;
        }

        if ($user->getPassword() !== $password) {
            $this->render('login', ['messages' => ['Wrong password!']]);
            return;
        }

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/preferencesSurvey");

        //return $this->render('preferencesSurvey');

    }
}