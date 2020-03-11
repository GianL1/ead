<?php 

namespace Controllers;

use \Core\Controller;
use \Models\Alunos;
use \Models\Usuarios;
use \Models\Cursos;

class AlunosController extends Controller {
    public function __construct(){
        $u = new Usuarios();
        if(!$u->isLogged()){
            header("Location:".BASE_URL."login");
        }
    }

    public function index(){
        $dados = array(
            'alunos' => array()
        );
        
        $alunos = new Alunos();
        $dados['alunos'] = $alunos->getAlunos();
        $this->loadTemplate('alunos', $dados);
    }

    public function adicionar(){
        $dados = array();
        $alunos = new Alunos();


        if(isset($_POST['nome']) && !empty($_POST['nome'])) {
            
            $nome = addslashes($_POST['nome']);
            $email = addslashes($_POST['email']);
            $senha = md5($_POST['senha']);

            $alunos->adicionarAluno($nome, $email, $senha);

            header("Location:".BASE_URL.'alunos');
        }

        $this->loadTemplate('alunos_add',$dados);
    }

    public function editar($id) {
        $dados = array(
            'aluno' => array()
        );

        $alunos = new Alunos();
        $cursos = new Cursos();

        if(isset($_POST['nome'])&& !empty($_POST['nome'])) {
            $nome = addslashes($_POST['nome']);
            $email = addslashes($_POST['email']);
            $senha = md5($_POST['senha']);
            $cursos = $_POST['cursos'];


            $alunos->editarAluno($id,$nome, $email, $senha, $cursos);

            header("Location:".BASE_URL);
        }

        
        $dados['aluno'] = $alunos->getAluno($id);
        $dados['cursos'] = $cursos->getCursos();
        $dados['inscrito'] = $cursos->getCursosInscritos($id);
        $this->loadTemplate('alunos_edit', $dados);
    }
}