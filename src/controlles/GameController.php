<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/Game.php';
require_once __DIR__.'/../repository/GameRepository.php';
require_once __DIR__.'/../repository/AttributeRepository.php';
require_once __DIR__.'/../repository/UserRepository.php';

class GameController extends AppController
{
    public const MAX_FILE_SIZE = 1024*1024;
    public const SUPORTED_TYPES = ['image/png','image/jpg'];
    public const UPLOAD_DIRECTORY = "/../public/uploads/";

    private array $messages = [];
    private GameRepository $gameRepo;
    private UserRepository $userRepo;

    private $notLoggedInMessage = "";
    
    public function __construct()
    {
        parent::__construct();
        $this->gameRepo = new GameRepository();
        $this->attributeRepo = new AttributeRepository();
    }
    
    
    public function addGame()
    {
        if($this->isPost())
        {
            $game = new Game($_POST['title'],$_POST['description']);

            if(isset($_FILES['file']) &&
                is_uploaded_file($_FILES['file']['tmp_name']) &&
                $this->validate($_FILES['file'])
                )
                {
                    move_uploaded_file(
                        $_FILES['file']['tmp_name'],
                        dirname(__DIR__) . self::UPLOAD_DIRECTORY . $_FILES['file']['name'],
    
                    );
                    $game->addImage($_FILES['file']['name']);
                }

            $this->gameRepo->addGame($game);
            $addedGameId = $this->gameRepo->getGameId($game->getTitle());
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/gamePage?title=".$game->getTitle()."&id_game=".$addedGameId);
            $this->render("gamePage" , ["messages" => $this->messages,'game'=>$game]);
            
            return;
        }

        if($this->isGet())
        {
            $this->render(
                'addGame',
                [
                    "messages" => $this->messages
                ]
            );
        }
    }
    
    
    public function gamePage() : void
    {
        
        $gameRepo = new GameRepository();
        $userRepo = new UserRepository();
        
        if($_GET['title'] === null)
            return;
        
        
        $fetchedGame = $this->gameRepo->getGameByTitle($_GET['title']);
        
        if($fetchedGame === null)
        {
            echo "game not found";
            return;
        }
        
        if($this->isPost() && $_POST !== null)
        {
            
            if($_COOKIE['email'] === null)
            {
                $notLoggedInMessage = 'your are not logged in';
                $this->render("gamePage",['game' => $fetchedGame, 'notLoggedIn' => $notLoggedInMessage]);
            }
            
            $attributeCount = count($_POST)/2;
            
            for ($i = 0 ; $i < $attributeCount ; $i++)
            {
                
                $newAttribute = ['name' => $_POST['attributeName_'.($i)],'score' => $_POST['attributeScore_'.($i)]];
                
                
                if(!$gameRepo->addAttributeToGame($_COOKIE['email'],$fetchedGame->getTitle() ,$newAttribute['name'],(int)$newAttribute['score']))
                {
                    break;
                }
                
                $gameRepo->setGameAttributes($fetchedGame);
                
            }
            
        }
        
        //echo '<pre>'; print_r($fetchedGame); echo '</pre>';
        $this->render("gamePage",['game' => $fetchedGame]);
        
    }
    
    
    
    
    
    private function validate(array $file) : bool
    {
        if($file['size'] > self::MAX_FILE_SIZE)
        {
            $this->messages = 'File is too large - max file size = 1024kb';
            return false;
        }

        if(!isset($file['type']) && !in_array( $file['type'],self::SUPORTED_TYPES ,true) )
        {
            $this->messages[] = 'file type is not supported - supported types : ' . self::SUPORTED_TYPES;
            return false;
        }

        return true;
    }
    

}