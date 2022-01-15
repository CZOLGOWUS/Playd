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
            'SELECT image_path FROM public."Images" WHERE id_game = :id'
        );
        $imageStatement->bindParam(':id', $id, PDO::PARAM_INT);
        $imageStatement->execute();
        
        $games = $statement->fetchAll(PDO::FETCH_ASSOC);
        $gameImages = $imageStatement->fetchAll(PDO::FETCH_ASSOC);
        
        if($games === false || $gameImages === false)
        {
            return array();
        }
        
        foreach ($games as $game)
        {
            $nextGame = new Game( $game['title'], $game['description']);
            foreach ($gameImages as $image)
            {
                $nextGame->addImage($image['image_path']);
            }
            $games[] = $nextGame;
            
        }
        
        return $games;
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