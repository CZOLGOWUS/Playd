<?php

require_once "Game.php";

class User
{
    private $username;
    private $email;
    private $password;
    private array $preferences = [];

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


    public function addPreference(string $attribute,int $score )
    {
        if(!isset(Game::getAllAttributes()[$attribute]))
        {
            Game::addNewAttribute($attribute);
        }

        $preferences[$attribute] = $score;
    }

}