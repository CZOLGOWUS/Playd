<?php

class Game
{
    private static array $allAttributes = ["heavy atmosphere","light atmosphere","challenging","casual"];

    private $title;
    private $description;
    private $image;
    private $attributes;
    private $steamUserScore;


    public function __construct($title, $description, $image)
    {
        $this->title = $title;
        $this->description = $description;
        $this->image = ["0" => $image];
    }

    //region geters_setters
    public function getTitle()
    {
        return $this->title;
    }


    public function setTitle(string $title): void
    {
        $this->title = $title;
    }


    public function getDescription() : string
    {
        return $this->description;
    }


    public function setDescription(string $description): void
    {
        $this->description = $description;
    }


    public function getImages() : array
    {
        return $this->image;
    }
    
    public function getImage(int $index) : string
    {
        return $this->image[$index];
    }

/*
 * array of strings of names from the database images
 * */
    public function setAllImages(array $image): void
    {
        $this->image = $image;
    }

    public function addImage(string $image)
    {
        $this->image[] = $image;
    }
    
    public function getAttributes()
    {
        return $this->attributes;
    }


    public function setAllAttributes($attributes): void
    {
        $this->attributes = $attributes;
    }
    
    public static function getAllAttributes():array
    {
        return self::$allAttributes;
    }
    
    /*
     * from 0 to 100 percent
     * */
    public function getSteamUserScore():int
    {
        return $this->steamUserScore;
    }
    
    /*
     * from 0 to 100 percent
     * */
    public function setSteamUserScore(int $score) : void
    {
        $this->steamUserScore = $score;
    }
    

    
    //endregion

    public static function addNewAttribute(string $attribute)
    {
        if (!isset(self::$allAttributes[$attribute])) {
            self::$allAttributes[] = $attribute;
        }
    }
    


}