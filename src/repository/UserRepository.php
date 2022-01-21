<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/User.php';

class UserRepository extends Repository
{
    public function getUser(string $email) : ?User
    {
        $statement = $this->database->connect()->prepare(
            'SELECT * FROM public."Users" WHERE email = :email'
        );
        $statement->bindParam(':email',$email,PDO::PARAM_STR);
        $statement->execute();
        
        $user = $statement->fetch(PDO::FETCH_ASSOC);
        
        if($user == false)
        {
            return null;
        }
        
        return new User(
            $user['username'],
            $user['email'],
            $user['password']
        );
    }
    
    public function addUser(User $user) : void
    {
        
        $statement = $this->database->connect()->prepare(
            '
                    INSERT INTO public."Users" (email, username, password)
                    VALUES(?,?,?)
                  '
        );
        
        $statement->execute(
            [
                $user->getEmail(),
                $user->getUsername(),
                $user->getPassword(),
            ]
        );
    }
}