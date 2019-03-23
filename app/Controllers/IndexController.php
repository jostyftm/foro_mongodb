<?php 

namespace App\Controllers;

class IndexController extends BaseController
{
    public function index()
    {
        return $this->renderView('home.twig', []);
    }   
}
