<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../repository/UserRepository.php';

class RegistrationCompletionController extends AppController
{
    
    public function registerComplete() : void
    {
        if($this->isGet())
        {
            $this->render('register');
            return;
        }
    
        $userRepo = new UserRepository();
        $user = new User($_POST['username'],$_POST['email'],$_POST['password']);
        if(
            str_replace(' ', '', $user->getEmail()) === '' ||
            str_replace(' ','',$user->getUsername()) === '' ||
            str_replace(' ','',$user->getPassword()) === '' )
        {
            $this->render('register',['messages' => ['some of the inputs are empty']]);
            return;
        }
        
    
        $fetchedUser = $userRepo->getUser($user->getEmail());
        if (isset($fetchedUser))
        {
            $this->render('register',['messages' => ['e-mail already in use']]);
            return;
        }
        
        $userRepo->addUser($user);
        
        $this->render('registerComplete');
        
    }
    
}
