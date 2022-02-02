<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../models/Game.php';

class AttributeRepository extends Repository
{
    
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
    
    
    public function getAllAttributesWithId(): array
    {
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
        
        return $convertedAttributeArray;
    }
    
    
    
    
    
    public function InsertNewAttributeToDb(int $id_creator, string $attribute): void
    {
        $attributeInsertStatement = $this->database->connect()->prepare(
            '
                INSERT INTO public."Attributes" (id_creator,name)
                VALUES (?,?)
                '
        );
        $attributeInsertStatement->execute(
            [
                $id_creator,
                $attribute
            ]
        );
    }
    
    
    public function getAttributeId(string $attribute): ?int
    {
        $getNewAttributeIdStatement = $this->database->connect()->prepare(
            '
                SELECT id_attribute FROM "Attributes"
                where name = :name
                '
        );
        
        $getNewAttributeIdStatement->bindParam(":name", $attribute, PDO::PARAM_STR);
        $getNewAttributeIdStatement->execute();
        return $getNewAttributeIdStatement->fetch(PDO::FETCH_ASSOC)['id_attribute'];
        
    }
    
}