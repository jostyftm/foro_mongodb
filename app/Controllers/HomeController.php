<?php 
namespace App\Controllers;

class HomeController extends BaseController
{
    public function index()
    {
        return $this->renderView('home.twig', [
            'user'  =>  $this->user
        ]);
    }
}
