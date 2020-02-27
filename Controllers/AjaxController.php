<?php 
namespace Controllers;

use \Core\Controller;
use \Models\Alunos;
use \Models\Aulas;

class AjaxController extends Controller {

    public function __construct(){
        $a = new Alunos();
        if(!$a->isLogged()){
            header("Location:".BASE_URL."login");
        }
    }

    public function marcarAssistido($id_aula){
        $aula = new Aulas();
        $aula->marcarAssistido($id_aula);
    }
}