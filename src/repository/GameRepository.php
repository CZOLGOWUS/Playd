<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../models/Game.php';

class GameRepository extends Repository
{
    public function getGameById(int $id) : ?Game
    {
        $statement = $this->database->connect()->prepare(
            'SELECT * FROM public."Games" WHERE id_game = :id'
        );
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
    
        $imageStatement = $this->database->connect()->prepare(
            'SELECT image_path FROM public."Images" WHERE id_game = :id'
        );
        $imageStatement->bindParam(':id', $id, PDO::PARAM_INT);
        $imageStatement->execute();
    
        $game = $statement->fetch(PDO::FETCH_ASSOC);
        $gameImages = $imageStatement->fetchAll(PDO::FETCH_ASSOC);
    
        if ($game === false || $gameImages === false)
        {
            return null;
        }
    
        $result = new Game(
            $game['title'],
            $game['description']
        );
        
        foreach ($gameImages as $image)
        {
            $result->addImage($image['image_path']);
        }
    
        return $result;
    }
    
    public function getGameByTitle(string $title) : ?Game
    {
        $statement = $this->database->connect()->prepare(
            'SELECT * FROM public."Games" WHERE title = :title'
        );
        $statement->bindParam(':title',$title,PDO::PARAM_STR);
        $statement->execute();
        
        $game = $statement->fetch(PDO::FETCH_ASSOC);
        
        $imageStatement = $this->database->connect()->prepare(
            'SELECT image_path FROM public."Images" WHERE id_game = :id'
        );
        $imageStatement->bindParam(':id', $id, PDO::PARAM_INT);
        $imageStatement->execute();
        $gameImages = $imageStatement->fetchAll(PDO::FETCH_ASSOC);
        
        if($game === false || $gameImages === false)
        {
            return null;
        }
        
        $result = new Game( $game['title'], $game['description']);
        foreach ($gameImages as $image)
        {
            $result->addImage($image['image_path']);
        }
        
        return $result;
    }
    
    public function getGames() : array
    {
        $games = [];
        
        $statement = $this->database->connect()->prepare(
            'SELECT * FROM public."Games"'
        );
        
        $statement->execute();
    
        $imageStatement = $this->database->connect()->prepare(
            'SELECT id_game,image_path FROM public."Images"'
        );
        
        $imageStatement->execute();
    
        $attributeStatement = $this->database->connect()->prepare(
            '
            SELECT "Games".id_game, "Attributes".name, avg("User_game_score".score) as game_attribute_score
            FROM "Games"
            left join "User_game_score" on "Games".id_game = "User_game_score".id_game
            left join "Attributes" on "Attributes".id_attribute = "User_game_score".id_attribute
            GROUP BY "Games".id_game, "Attributes".name
                    '
        );
    
        $attributeStatement->execute();
    
        $attributes = $attributeStatement->fetchAll(PDO::FETCH_ASSOC);
        $games = $statement->fetchAll(PDO::FETCH_ASSOC);
        $gameImages = $imageStatement->fetchAll(PDO::FETCH_ASSOC);
        
        if($games === false || $gameImages === false)
        {
            return array();
        }
        
        $imagesOfId = array();

        //var_dump($imagesOfId[$games[0]['id_game']]);
        
        $resultGames = array();
        foreach ($games as $game)
        {
            //associate all images with their id_game
            $imagesOfId[] = [$game['id_game'] => []];
            foreach ($gameImages as $image)
            {
                if($image['id_game'] === $game['id_game'])
                {
                    $imagesOfId[$game['id_game']][] = $image['image_path'];
                }
            }
            
            $nextGame = new Game( $game['title'], $game['description']);
            
            //add images to their objects
            if(!$imagesOfId[$game['id_game']] == array())
                $nextGame->setAllImages($imagesOfId[$game['id_game']]);
            //var_dump($nextGame);
            $gameAttributeArray = array_filter(
                $attributes,
                static function ($attribute) use ($game)
                {
                    return ($attribute['id_game'] == $game['id_game']);
                }
            );
            
            $nextGame->setAllAttributes($gameAttributeArray);
            
            $resultGames[] = $nextGame;
            
        }
        
        return $resultGames;
    }
    
    public function addGame(Game $game) : void
    {
        $date = new DateTime();
        $statement = $this->database->connect()->prepare(
            '
                    INSERT INTO "Games" (id_creator,title,description,created_at)
                    VALUES(?,?,?,?)
                  '
        );
        
        $id_creator = 1;
        $statement->execute(
          [
            $id_creator,
            $game->getTitle(),
            $game->getDescription(),
            $date->format('Y-m-d')
          ]
        );
    }
    
}