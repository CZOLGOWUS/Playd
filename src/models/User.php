<?php

require_once "Game.php";
require_once __DIR__."/../repository/UserRepository.php";

class User
{
    private $username;
    private $email;
    private $password;
    private $attributes; // ['attribute' => 'score' ,'att' => 'score'...]
    

    public function __construct(string $username,string $email,string $password)
    {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
    
    public function getAttribute(string $attribute) : array
    {
        $result = $this->attributes[$attribute];
        return $result === null ? [] : [$attribute => $result ] ;
    }
    
    public function setAttribute(string $name, int $score) : bool
    {
        $result = $this->attributes[$name];
        if($result !== null)
            return false;
        
        $this->attributes[$name] = $score;
        
        return  true;
            
    }
    
    public function getAttributes(): array
    {
        return $this->attributes;
    }
    
    public function setAttributes(array $attributes): void
    {
        $this->attributes = $attributes;
    }
    
    
    public function addAttribute(string $attribute, int $score ) : void
    {
        if(!isset(Game::getAllAttributes()[$attribute]))
        {
            Game::addNewAttribute($attribute);
        }

        $preferences[$attribute] = $score;
    }

}