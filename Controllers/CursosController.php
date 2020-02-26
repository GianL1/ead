<?php 

namespace Controllers;

use \Core\Controller;
use \Models\Alunos;
use \Models\Cursos;
use \Models\Modulos;
use \Models\Aulas;

class CursosController extends Controller {

    public function __construct(){
        $a = new Alunos();
        if(!$a->isLogged()){
            header("Location:".BASE_URL."login");
        }
    }

    public function index(){
        header("Location:".BASE_URL);
    }

    public function entrar($id_curso){
        $dados = array(
            'info' => array(),
            'curso' => array(),
            'modulos' => array(),
        );

        $alunos = new Alunos();
        $alunos->setAluno($_SESSION['lgaluno']);
        $dados['info'] = $alunos;

        

        if($alunos->isInscrito($id_curso)) {
            $cursos = new Cursos();
            $cursos->setCurso($id_curso);
            
            
            $dados['curso'] = $cursos;

            $modulos = new Modulos();
            $dados['modulos'] = $modulos->getModulos($id_curso);
            
            
            $this->loadTemplate('curso_entrar', $dados);
        }else {
            
            header("Location:".BASE_URL);
        }
    }

    public function aula($id_aula){
        $dados = array(
            'info' => array(),
            'curso' => array(),
            'modulos' => array(),
            'aula' => array()
        );

        $alunos = new Alunos();
        $alunos->setAluno($_SESSION['lgaluno']);
        $dados['info'] = $alunos;

        $aula = new Aulas();
        $id = $aula->getCursoDeAula($id_aula);

        if($alunos->isInscrito($id)) {
            $cursos = new Cursos();
            $cursos->setCurso($id);
            
            
            $dados['curso'] = $cursos;

            $modulos = new Modulos();
            $dados['modulos'] = $modulos->getModulos($id);
            $dados['aula_info'] = $aula->getAula($id_aula);

            if($dados['aula_info']['tipo'] == 'video') {
                $view = 'curso_aula_video';
            }else {
                $view = 'curso_aula_poll';
                if(!isset($_SESSION['poll'.$id_aula])) {
                    $_SESSION['poll'.$id_aula] = 1;
                }
                
                
            }
            
            if (isset($_POST['duvida']) && !empty($_POST['duvida'])) {
                $duvida = addslashes($_POST['duvida']);
                $aula->setDuvida($duvida, $alunos->getId());
            }

            if(isset($_POST['opcao']) && !empty($_POST['opcao'])) {
                $opcao = addslashes($_POST['opcao']);

                if($opcao == $dados['aula_info']['resposta']) {
                    $dados['resposta'] = true;
                }else {
                    $dados['resposta'] = false;
                }
                $_SESSION['poll'.$id_aula] ++;
                
            }
            
            $this->loadTemplate($view, $dados);
        }else {
            
            header("Location:".BASE_URL);
        }
    }
}