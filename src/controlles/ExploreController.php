<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../models/Game.php';
require_once __DIR__.'/../repository/GameRepository.php';

class ExploreController extends AppController
{
    public const NUMBER_OF_GAMES_TO_DISPLAY = 30 ;
    private array $preferences;
    private GameRepository $gameRepo;
    private array $games = array();
    
    public function __construct()
    {
        parent::__construct();
        $this->gameRepo = new GameRepository();
    }
    
    public function explore()
    {
        
        $allGames = $this->gameRepo->getGames();
        
        
        shuffle($allGames);
        //echo '<pre>'; print_r($gameRepo->getGames()); echo '</pre>';
        $this->render('explore', ['games' => $allGames]);
    }
    
    public function search() : void
    {
        $contentType = isset($_SERVER['CONTENT_TYPE']) ? trim($_SERVER['CONTENT_TYPE']) : '';
        if($contentType === 'application/json')
        {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            
            
            header('Content-Type: application/json');
            http_response_code(200);
            
            echo json_encode( $this->gameRepo->fetchGamesByTitle($decoded['search']));
        }
    }
    
}