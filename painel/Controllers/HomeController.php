<?php

namespace Controllers;

use \Core\Controller;
use \Models\Usuarios;
use \Models\Cursos;
use \Models\Modulos;
use \Models\Aulas;

class HomeController extends Controller {

    public function __construct(){
        $u = new Usuarios();
        if(!$u->isLogged()){
            header("Location:".BASE_URL."login");
        }
    }

    public function index(){
        $dados = array(
            'cursos' => array()
        );
        
        $cursos = new Cursos();
        $dados['cursos'] = $cursos->getCursos();
        $this->loadTemplate('home', $dados);
    }
    
    public function excluir($id_curso){
        $cursos = new Cursos();

        $cursos->excluirCurso($id_curso);

        header("Location:".BASE_URL."login");
    }

    public function adicionar(){
        $dados = array();

        if(isset($_POST['nome']) && !empty($_POST['nome'])) {
            $nome = addslashes($_POST['nome']);
            $descricao = addslashes($_POST['descricao']);
            $imagem = $_FILES['imagem'];

            if(!empty($imagem['tmp_name'])) {
                $md5name = md5(time()).'.jpg';
                $types = array('image/jpg', 'image/jpeg', 'image/png');

                if(in_array($imagem['type'], $types)) {
                    move_uploaded_file($imagem['tmp_name'], "../Assets/Images/cursos/".$md5name);

                    $cursos = new Cursos();
                    $cursos->adicionarCurso($nome, $descricao, $md5name);
                }
            }
        }

        $this->loadTemplate('curso_add',$dados);
    }

    public function editar($id_curso) {
        $dados = array(

        );

        $cursos = new Cursos();
        $modulos = new Modulos();
        $aulas = new Aulas();

        if(isset($_POST['nome'])&& !empty($_POST['nome'])) {
            $nome = addslashes($_POST['nome']);
            $descricao = addslashes($_POST['descricao']);
            $imagem = $_FILES['imagem'];

            $cursos->editarCurso($nome, $descricao, $imagem, $id_curso);

            header("Location:".BASE_URL);
        }

        if(isset($_POST['modulo']) && !empty($_POST['modulo'])) {
            $modulo = addslashes($_POST['modulo']);

            $modulos->adicionarModulo($modulo, $id_curso);

            header("Location:".BASE_URL);
        }

        if(isset($_POST['nome_aula']) && !empty($_POST['nome_aula'])) {
            $aula = addslashes($_POST['nome_aula']);
            $modulo_aula = addslashes($_POST['modulo_aula']);
            $tipo = addslashes($_POST['tipo']);

            $aulas->addAula($id_curso, $modulo_aula, $aula, $tipo);
        }

        
        $dados['cursos'] = $cursos->getCurso($id_curso);
        $dados['modulos'] = $modulos->getModulos($id_curso);

        $this->loadTemplate('curso_edit', $dados);
    }

    public function del_modulo($id_modulo){
        $modulos = new Modulos();
        if(!empty($id_modulo)) {
            $modulos->deletarModulo($id_modulo);
        }
        header("Location:".BASE_URL);
        exit;
    }

    public function edit_modulo($id_modulo){
        $dados = array();

        $modulos = new Modulos();

        $dados['modulo'] = $modulos->getModulo($id_modulo);

        if(isset($_POST['nome']) && !empty($_POST['nome'])) {
            
            $nome = addslashes($_POST['nome']);

            $modulos->editarModulo($nome, $id_modulo);
            header("Location:".BASE_URL);
            exit;
        }

        $this->loadTemplate('curso_edit_modulo', $dados);
    }

    public function del_aula($id_aula){
        $aulas = new Aulas();
        if(!empty($id_aula)) {
            $aulas->deleteAula($id_aula);
        }
        header("Location:".BASE_URL);
        exit;
    }

    public function edit_aula($id_aula){
        $dados = array();
        $view = 'curso_edit_aula_video';
        $aulas = new Aulas();

        if(isset($_POST['nome']) && !empty($_POST['nome'])) {
            $nome = addslashes($_POST['nome']);
            $descricao = addslashes($_POST['descricao']);
            $url = addslashes($_POST['url']);

            $aulas->updateVideoAula($id_aula, $nome, $descricao, $url);

            header("Location:".BASE_URL);
        }

        if(isset($_POST['pergunta']) && !empty($_POST['pergunta'])) {
            $pergunta = addslashes($_POST['pergunta']);
            $opcao1 = addslashes($_POST['opcao1']);
            $opcao2 = addslashes($_POST['opcao2']);
            $opcao3 = addslashes($_POST['opcao3']);
            $opcao4 = addslashes($_POST['opcao4']);
            $resposta = addslashes($_POST['resposta']);


            $aulas->updateQuestionarioAula($id_aula, $pergunta, $opcao1, $opcao2, $opcao3, $opcao4, $resposta);

            header("Location:".BASE_URL);
        }

        

        $dados['aula'] = $aulas->getAula($id_aula);

        if($dados['aula']['tipo'] == 'video') {
            $view = 'curso_edit_aula_video';
        }else {
            $view = 'curso_edit_aula_poll';
        }

        $this->loadTemplate($view, $dados);
    }
}