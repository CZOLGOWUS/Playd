<?php

class Game
{
    private static array $allAttributes = ["heavy atmosphere","light atmosphere","challenging","casual"];

    private $title;
    private $description;
    private $image;
    private $attributes;


    public function __construct($title, $description, $image)
    {
        $this->title = $title;
        $this->description = $description;
        $this->image = $image;
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


    public function getImage() :string
    {
        return $this->image;
    }


    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }


    public function setAttributes($attributes): void
    {
        $this->attributes = $attributes;
    }

    public static function getAllAttributes():array
    {
        return self::$allAttributes;
    }

    //endregion

    public static function addNewAttribute(string $attribute)
    {
        if (!isset(self::$allAttributes[$attribute])) {
            self::$allAttributes[] = $attribute;
        }
    }





}