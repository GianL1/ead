<?php

namespace Controllers;

use \Core\Controller;
use \Models\Usuarios;
use \Models\Cursos;

class HomeController extends Controller {

    public function __construct(){
        $u = new Usuarios();
        if(!$u->isLogged()){
            header("Location:".BASE_URL."login");
        }
    }

    public function index(){
        $dados = array(

        );
        
       
        
        $this->loadTemplate('home', $dados);
    }
    
}