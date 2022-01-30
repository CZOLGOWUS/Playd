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
    
    
    public function explore()
    {
        $gameRepo = new GameRepository();
        $idUsed = array();
        
        $this->render('explore', ['games' => $gameRepo->getGames()]);
    }
    
}