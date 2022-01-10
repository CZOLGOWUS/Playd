<?php

require_once 'AppController.php';

class DefaultController extends AppController
{

    public function index()
    {
        $this->render('indexPage');
    }

    public function preferencesSurvey()
    {
        $this->render("preferencesSurvey");
    }

    public function addGame()
    {
        $this->render("addGame");
    }

    public function contact()
    {
        $this->render("contact");
    }
    
}
