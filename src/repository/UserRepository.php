<?php

require_once 'Repository.php';
require_once 'AttributeRepository.php';
require_once __DIR__.'/../models/User.php';

class UserRepository extends Repository
{
    private AttributeRepository $attributeRepo;
    

    public function __construct()
    {
        parent::__construct();
        $this->attributeRepo = new AttributeRepository();
    }
    
    
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
    
    
    
    
    public function getUserWithDBData(string $email) : ?array
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
        
        $userInstance = new User(
        $user['username'],
        $user['email'],
        $user['password']
        );
        
        $userInstance->setAttributes($this->attributeRepo->getUserAttributes($email));
        
        return array(
            'user' => $userInstance,
            'id_user' => $user['id_user']
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
    
    
    
    
    
    public function addAttributeToUser(string $email, string $attribute, int $score) : bool
    {
        
        $userAttributes = $this->attributeRepo->getUserAttributes($email);
        
        if(array_key_exists($attribute,$userAttributes))
        {
            return false;
        }
        
        $userDB = $this->getUserWithDBData($email);
    
        $attributeId = array_search($attribute, $this->attributeRepo->getAllAttributesWithId(), true);
        
        if(!$attributeId)
        {
            $this->attributeRepo->InsertNewAttributeToDb($userDB['id_user'], $attribute);
    
            $attributeId = $this->attributeRepo->getAttributeId($attribute);
    
        }
    
        $this->insertNewUserPreference($userDB['id_user'], $attributeId, $score);
    
        return true;
    }
    
    
    

    public function insertNewUserPreference(int $id_user, int $id_attribute, int $score): void
    {
        $insertStatement = $this->database->connect()->prepare(
            '
                    INSERT INTO public."User_preferences" (id_user, id_attribute, score)
                    VALUES(?,?,?)
                  '
        );
        
        $insertStatement->execute(
            [
                $id_user,
                $id_attribute,
                $score
            ]
        
        );
    }
    
    
}