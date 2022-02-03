<?php

require_once 'Repository.php';
require_once 'AttributeRepository.php';
require_once 'UserRepository.php';
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
        $fetchedGame = $statement->fetch(PDO::FETCH_ASSOC);
        
        $result = $this->instantiateGameWithImages($id,$fetchedGame['title'],$fetchedGame['description']);
        
        if($result === null)
            return null;
    
        $this->setGameAttributes($result);
        $result->setId($id);
    
        return  $result;
    }
    
    public function getGameByTitle(string $title) : ?Game
    {
        $statement = $this->database->connect()->prepare(
            'SELECT * FROM public."Games" WHERE title = :title'
        );
        $statement->bindParam(':title',$title,PDO::PARAM_STR);
        $statement->execute();
        $game = $statement->fetch(PDO::FETCH_ASSOC);
        
        $id = $game['id_game'];
        $result = $this->instantiateGameWithImages($id, $game['title'], $game['description']);
        
        if($result === null)
            return null;
        
        $this->setGameAttributes($result);
        $result->setId($id);
        
        return  $result;
    }
    
    
    public function setGameAttributes(Game $game) : void
    {
        $attributeStatement = $this->database->connect()->prepare(
            '
            SELECT "Games".id_game, "Attributes".name, avg("User_game_score".score) as game_attribute_score
            FROM "Games"
                     left join "User_game_score" on "Games".id_game = "User_game_score".id_game
                     left join "Attributes" on "Attributes".id_attribute = "User_game_score".id_attribute
            GROUP BY "Games".id_game, "Attributes".name having "Games".id_game = :id
                    '
        );
        $id = $game->getId();
        $attributeStatement->bindParam(':id', $id, PDO::PARAM_INT);
        $attributeStatement->execute();
        
        $attributeList = $attributeStatement->fetchAll(PDO::FETCH_ASSOC);
    
        $response = $attributeList;
        $converted = array();
    
        foreach ($response as $row)
        {
            $converted[$row['name']] = $row['game_attribute_score'];
        }
        
        $game->setAllAttributes($converted);
        
    }
    
    public function instantiateGameWithImages($id_game, $title, $description): ?Game
    {
        $imageStatement = $this->database->connect()->prepare(
            'SELECT image_path FROM public."Images" WHERE id_game = :id'
        );
        $imageStatement->bindParam(':id', $id_game, PDO::PARAM_INT);
        $imageStatement->execute();
        
        $gameImages = $imageStatement->fetchAll(PDO::FETCH_ASSOC);
        
        if ($title === false || $description === false || $gameImages === false)
        {
            return null;
        }
        
        $result = new Game(
            $title,
            $description
        );
        
        foreach ($gameImages as $image)
        {
            $result->addImage($image['image_path']);
        }
        $result->setId($id_game);
        
        return $result;
    }
    
    
    
    public function getGames() : array
    {
        $games = [];
        
        $statement = $this->database->connect()->prepare(
            'SELECT * FROM public."Games"'
        );
        
    
        $imageStatement = $this->database->connect()->prepare(
            'SELECT id_game,image_path FROM public."Images"'
        );
        
    
        $attributeStatement = $this->database->connect()->prepare(
            '
            SELECT "Games".id_game, "Attributes".name, avg("User_game_score".score) as game_attribute_score
            FROM "Games"
            left join "User_game_score" on "Games".id_game = "User_game_score".id_game
            left join "Attributes" on "Attributes".id_attribute = "User_game_score".id_attribute
            GROUP BY "Games".id_game, "Attributes".name
                    '
        );
    
        
        $statement->execute();
        $imageStatement->execute();
        $attributeStatement->execute();
    
        $attributes = $attributeStatement->fetchAll(PDO::FETCH_ASSOC);
        $games = $statement->fetchAll(PDO::FETCH_ASSOC);
        $gameImages = $imageStatement->fetchAll(PDO::FETCH_ASSOC);
        
        if($games === false || $gameImages === false)
        {
            return array();
        }
        
        $imagesOfId = array();
        
        
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
            
            $gameAttributeArray = array_filter(
                $attributes,
                static function ($attribute) use ($game)
                {
                    return ($attribute['id_game'] == $game['id_game']);
                }
            );
    
            $response = $gameAttributeArray;        // your database response
            $converted = array();               // declaring some clean array, just to be sure
    
            foreach ($response as $row)
            {
                $converted[$row['name']] = $row['game_attribute_score'];        // entire row (for example $response[1]) is copied
            }
            
            $nextGame->setId($game['id_game']);
            $nextGame->setAllAttributes($converted);
            
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
        
        $userRepo = new UserRepository();
        
        if($_COOKIE['email'] === null)
        {
            echo 'no user is logged in, please log in';
            return;
        }
        
        $id_creator = $userRepo->getUserWithDBData($_COOKIE['email'])['id_user'];
        
        $statement->execute(
          [
            $id_creator,
            $game->getTitle(),
            $game->getDescription(),
            $date->format('Y-m-d')
          ]
        );
    }
    
    public function getGameId(string $title) : int
    {
        $statement = $this->database->connect()->prepare(
            '
                    SELECT id_game FROM "Games" where title = :title
                  '
        );
        
        $statement->bindParam(':title',$title,PDO::PARAM_STR);
        $statement->execute();
        
        $gameTitle = $statement->fetch(PDO::FETCH_ASSOC);
        
        return $gameTitle['id_game'];
        
    }
    
    public function addAttributeToGame(string $email, string $title, string $attribute, int $score) : bool
    {
        
        $attributeRepo = new AttributeRepository();
        $userRepo = new UserRepository();
        
        $fetchedUser = $userRepo->getUserWithDBData($email);
        $fetchedGame = $this->getGameByTitle($title);
        $fetchedGamesAttributes = $attributeRepo->getAllAttributesWithId();
        
        if($fetchedGame === null || $fetchedUser === null || $fetchedGamesAttributes === null)
        {
            echo 'one of instances is null';
            return false;
        }

        $attributeId = $attributeRepo->getAttributeId($attribute);
        
        if($attributeId === null || $fetchedGamesAttributes[$attributeId] === null)
        {
            $attributeRepo->InsertNewAttributeToDb($fetchedUser['id_user'], $attribute);
        }
        
        $attributeId = $attributeRepo->getAttributeId($attribute);
        
        $insertStatement = $this->database->connect()->prepare(
            '
            INSERT INTO public."User_game_score" (id_user,id_game,id_attribute,score)
            VALUES (?,?,?,?)
            '
        );
    
        try
        {
            $insertStatement->execute(
                [
                    $fetchedUser['id_user'],
                    $fetchedGame->getId(),
                    $attributeId,
                    $score
                ]
            );
            
        }
        catch (PDOException $e)
        {

            $updateStatement = $this->database->connect()->prepare(
                '
                UPDATE public."User_game_score"
                SET id_attribute = ?, score = ?
                where id_user = ? and id_game = ?
                '
            );
            
            $updateStatement->execute(
                [
                    $attributeId,
                    $score,
                    $fetchedUser['id_user'],
                    $fetchedGame->getId()
                ]
            );

        }
        catch (Exception $e)
        {
            return false;
        }
        
        return true;
        
    }
    
    
    //fetch api
    public function fetchGamesByTitle(string $searchString) : array
    {
        $searchString = '%' . strtolower( $searchString ) .'%';
        
        /*    left join (SELECT first( \'[attribute,score]\'::json ) FROM "Attributes" ORDER BY "Attributes".id_attribute ) as attribute_0,
              (SELECT \'[attribute,score]\'::json) as attribute_1,
              (SELECT \'[attribute,score]\'::json) as attribute_2,*/
        
        $statement = $this->database->connect()->prepare(
            '
            SELECT id_game ,
                   title,
                   
                   (SELECT image_path FROM "Images" where "Games".id_game = "Images".id_game ORDER BY "Images".id_image ASC LIMIT 1) as image
            FROM "Games"
            
            where LOWER(title) LIKE :search OR LOWER("Games".description) LIKE :search
            '
        );
        
        $statement->bindParam(':search',$searchString,PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
        
    }
    
    
    public function addImageToGame($title, $image)
    {
    
    }
    
    
}