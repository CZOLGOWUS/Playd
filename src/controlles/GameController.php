<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/Game.php';
require_once __DIR__.'/../repository/GameRepository.php';

class GameController extends AppController
{
    const MAX_FILE_SIZE = 1024*1024;
    const SUPORTED_TYPES = ['image/png','image/jpg'];
    const UPLOAD_DIRECTORY = "/../public/uploads/";

    private $messages = [];
    private $gameRepository;
    
    public function __construct()
    {
        parent::__construct();
        $this->gameRepository = new GameRepository();
    }
    
    
    public function addGame()
    {
        if($this->isPost() &&
            is_uploaded_file($_FILES['file']['tmp_name']) &&
            $this->validate($_FILES['file']))
        {
            move_uploaded_file(
                $_FILES['file']['tmp_name'],
                dirname(__DIR__) . self::UPLOAD_DIRECTORY . $_FILES['file']['name'],

            );

            $game = new Game($_POST['title'],$_POST['description'],$_FILES['file']['name']);
            $this->gameRepository->addGame($game);
            
            
            $this->render("gamePage", ["messages" => $this->messages,'game'=>$game]);
            return;
        }

        $this->render("addGame",[
            'games' => $this->gameRepository->getGames(),
            "messages" => $this->messages
        ]);
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

    public function gamePage() : void
    {
        $game = $this->gameRepository->getGameById(7);
        
        $this->render("gamePage",['game' => $game]);
    }

}