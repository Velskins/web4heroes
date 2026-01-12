<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Response;

class HomeController extends Controller
{
    public function index(): Response
    {
        return $this->view('home', [
            'title' => 'Bienvenue sur le projet Web4Heroes',
            'message' => 'HomePage'
        ]);
    }
}
