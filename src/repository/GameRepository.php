<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../models/Game.php';

class GameRepository extends Repository
{
    public function getGame(int $id) : ?Game
    {
        $statement = $this->database->connect()->prepare(
            'SELECT * FROM public."Games" WHERE id_game = :id'
        );
        $statement->bindParam(':id',$id,PDO::PARAM_INT);
        $statement->execute();
        
        $game = $statement->fetch(PDO::FETCH_ASSOC);
        
        if($game == false)
        {
            return null;
        }
        
        return new Game(
            $game['title'],
            $game['description'],
            $game['image']
        );
    }
    
    public function addGame(Game $game) : void
    {
        $date = new DateTime();
        $statement = $this->database->connect()->prepare(
            '
                    INSERT INTO "Games" (id_creator,title,description,image,created_at)
                    VALUES(?,?,?,?,?)
                  '
        );
        
        $id_creator = 1;
        $statement->execute(
          [
            $id_creator,
            $game->getTitle(),
            $game->getDescription(),
            $game->getImage(0),
            $date->format('Y-m-d')
          ]
        );
    }
    
}