<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../models/Game.php';
require_once __DIR__.'/../repository/UserRepository.php';
require_once __DIR__.'/../repository/GameRepository.php';

class ProfileController extends AppController
{
    private string $email;
    private array $userAttributes = [];
    private UserRepository $userRepo;
    
    public function profile()
    {
        $email = $_COOKIE['email'];
        if($email == false)
        {
            return $this->render('login', ['messages' => ['please log in']]);
            
        }
        
        $userRepo = new UserRepository();
        $fetchedUserData = $userRepo->getUserWithDBData($email);
        
        if($fetchedUserData['user'] == null || $fetchedUserData['user']->getEmail() != $email)
        {
            return $this->render('login', ['messages' => ['something went wrong please try to log in again']]);
            
        }


        if($this->isPost())
        {
            
            if($_POST === null)
            {
                $this->render("profile", ['user' => $fetchedUserData['user']]);
                return;
            }
            
            $attributeCount = count( $_POST) / 2;
            for ($i = 0 ; $i < $attributeCount; $i++ )
            {
               $newAttribute = ['name' => $_POST['attributeName_'.($i)],'score' => $_POST['attributeScore_'.($i)]];
               $hasAttribute = $fetchedUserData['user']->getAttribute($newAttribute['name']) === null;
               
               
               if($hasAttribute)
                   continue;
               
               $fetchedUserData['user']->setAttribute($newAttribute['name'],$newAttribute['score']);
               if(!$userRepo->addAttributeToUser($fetchedUserData['user']->getEmail(),$newAttribute['name'],(int)$newAttribute['score']))
               {
                   echo 'problem with adding attribute to user in ProfileController';
                   return;
               }
               
            }
        }
        
        $this->render("profile",['user' => $fetchedUserData['user']]);
    }
    
}
