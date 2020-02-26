<?php

namespace Controllers;

use \Core\Controller;
use \Models\Alunos;
use \Models\Cursos;

class HomeController extends Controller {

    public function __construct(){
        $a = new Alunos();
        if(!$a->isLogged()){
            header("Location:".BASE_URL."login");
        }
    }

    public function index(){
        $dados = array(
            'info'=>array(),
            'cursos'=>array()
        );
        
        $alunos = new Alunos();
        $cursos = new Cursos();

        $alunos->setAluno($_SESSION['lgaluno']);

        $dados['info'] = $alunos;
        $dados['cursos'] = $cursos->getCursosAluno($alunos->getId());
        
        
        $this->loadTemplate('home', $dados);
    }
    
}