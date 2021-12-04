<?php

require_once 'AppController.php';

class DefaultController extends AppController
{

    public function index()
    {
        $this->render('indexPage');
    }

    public function login()
    {
        $this->render('login');
    }

    public function explore()
    {
        $this->render('Explore');
    }

    public function welcomePrefSurvey()
    {
        $this->render("welcomePrefSurvey");
    }

    public function addGame()
    {
        $this->render("addGame");
    }

}
