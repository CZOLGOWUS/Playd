<?php

class Game
{
    private static array $allAttributes = ["heavy atmosphere","light atmosphere","challenging","casual"];

    private $title;
    private ?int $id;
    private $description;
    private $images = [];
    private $attributes = []; //[['attribute_name' => '0.0'],[],[]]
    private $steamUserScore;


    public function __construct($title, $description)
    {
        $this->title = $title;
        $this->description = $description;
        $this->id = null;
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
    
    
    public function getId(): int
    {
        return $this->id;
    }
    
    
    public function setId(int $id): void
    {
        $this->id = $id;
    }
    
    
    public function getDescription() : string
    {
        return $this->description;
    }


    public function setDescription(string $description): void
    {
        $this->description = $description;
    }


    public function getAllImages() : array
    {
        return $this->images;
    }
    
    public function getImage(int $index) : string
    {
        if(!($this->images[$index] === null))
        {
            return $this->images[$index];
        }
        else
        {
            return "";
        }
    }

/*
 * array of strings of names from the database images
 * */
    public function setAllImages(array $images): void
    {
        $this->images = $images;
    }

    public function addImage(string $image) : void
    {
        $this->images[] = $image;
    }
    
    public function getAttributes()
    {
        return $this->attributes;
    }


    public function setAllAttributes($attributes): void
    {
        $this->attributes = $attributes;
    }
    
    public function addAttribute(string $attribute,int $score) : void
    {
        $this->attributes[$attribute] = $score;
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