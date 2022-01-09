<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/Game.php';

class GamePageController extends AppController
{
    const MAX_FILE_SIZE = 1024*1024;
    const SUPORTED_TYPES = ['image/png','image/jpg'];
    const UPLOAD_DIRECTORY = "/../public/uploads/";

    private $messages = [];
    public $game;

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

            $this->render("gamePage", ["messages" => $this->messages,'game'=>$game]);
            return;
        }

        $this->render("addGame",["messages" => $this->messages]);
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

    public function gamePage()
    {
        $game = new Game("title","desc","521516.jpg");
        $this->render("gamePage",['game'=>$game]);
    }

}