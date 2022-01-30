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
        
        $userInstance->setAttributes($this->getUserAttributes($email));
        
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
        
        $userAttributes = $this->getUserAttributes($email);
        
        if(array_key_exists($attribute,$userAttributes))
        {
            return false;
        }
        
        $userDB = $this->getUserWithDBData($email);
        
        
        $attributeStatement = $this->database->connect()->prepare(
          '
          SELECT id_attribute,name FROM "Attributes"
          '
        );
        $attributeStatement->execute();
        $fetchedAttributes = $attributeStatement->fetchAll(PDO::FETCH_ASSOC);
    
        $response = $fetchedAttributes;
        $convertedAttributeArray = array();
    
        foreach ($response as $row)
        {
            $convertedAttributeArray[$row['id_attribute']] = $row['name'];
        }
        
        $attributeId = array_search($attribute,$convertedAttributeArray,true);
        
        if(!$attributeId)
        {
            $attributeInsertStatement = $this->database->connect()->prepare(
                '
                INSERT INTO public."Attributes" (id_creator,name)
                VALUES (?,?)
                '
            );
            $attributeInsertStatement->execute(
                [
                    $userDB['id_user'],
                    $attribute
                ]
            );
            
            sleep(5);
            
            $getNewAttributeIdStatement = $this->database->connect()->prepare(
                '
                SELECT id_attribute FROM "Attributes"
                where id_creator = :id and name = :name
                '
            );
           
            $getNewAttributeIdStatement->bindParam(":id",$userDB['id_user'],PDO::PARAM_INT);
            $getNewAttributeIdStatement->bindParam(":name",$attribute,PDO::PARAM_STR);
            $getNewAttributeIdStatement->execute();
            $attributeId = $getNewAttributeIdStatement->fetch(PDO::FETCH_ASSOC);

        }
    
        $insertStatement = $this->database->connect()->prepare(
            '
                    INSERT INTO public."User_preferences" (id_user, id_attribute, score)
                    VALUES(?,?,?)
                  '
        );
        
        
        $insertStatement->execute(
            [
                $userDB['id_user'],
                $attributeId['id_attribute'],
                $score
            ]
            
        );
        
        return true;
    }
    
    
    public function getUserAttributes(string $email) : array
    {
        $selectStatement = $this->database->connect()->prepare(
            '
                SELECT name, score FROM public."Users"
                inner join "User_preferences" on "Users".id_user = "User_preferences".id_user
                inner join "Attributes" on "User_preferences".id_attribute = "Attributes".id_attribute
                where "Users".email = :email
                '
        );
    
        $selectStatement->bindParam(':email',$email);
        $selectStatement->execute();
        $userAttributes = $selectStatement->fetchAll(PDO::FETCH_ASSOC);
    
    
        $response = $userAttributes;        // your database response
        $converted = array();               // declaring some clean array, just to be sure

        foreach ($response as $row)
        {
            $converted[$row['name']] = $row['score'];        // entire row (for example $response[1]) is copied
        }
        
        return $converted;
    }
    

}