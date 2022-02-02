<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../repository/UserRepository.php';

class SecurityController extends AppController
{
    public function login()
    {
        
        $userRepo = new UserRepository();

        if (!$this->isPost()) {
            $this->render('login');
            return;
        }

        $email = $_POST['email'];
        $password = $_POST['password'];
        
        $user = $userRepo->getUser($email);
        
        if (!$user)
        {
            $this->render('login', ['messages' => ['User not exist!']]);
            return;
        }

        if ($user->getEmail() !== $email) {
            $this->render('login', ['messages' => ['User with this email not exist!']]);
            return;
        }

        if ($user->getPassword() !== $password) {
            $this->render('login', ['messages' => ['Wrong password!']]);
            return;
        }

        if(isset($_COOKIE['email']))
            unset($_COOKIE['email']);
        
        setcookie('email', $email ,time() + 3600,"/");
        
        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/profile");

        //return $this->render('profile');

    }
}