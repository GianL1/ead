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
        $dados = array();

        $cursos = new Cursos();
        $dados['curso'] = $cursos->getCurso($id_curso);

        $this->loadTemplate('curso_edit', $dados);
    }
}