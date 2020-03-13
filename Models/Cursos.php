<?php 

namespace Models;

use \Core\Model;

class Cursos extends Model {

    private $info;

    public function getCursosAluno($id_aluno){
        $array = array();

        $sql = $this->pdo->prepare("SELECT * FROM aluno_curso LEFT JOIN cursos ON aluno_curso.id_curso = cursos.id WHERE id_aluno = :id_aluno");
        $sql->bindValue(":id_aluno", $id_aluno);
        $sql->execute();

        if($sql->rowCount() > 0 ){
            $array = $sql->fetchAll();
        }

        return $array;
    }

    public function setCurso($id_curso){
        

        $sql = $this->pdo->prepare("SELECT * FROM cursos WHERE id = :id");
        $sql->bindValue(":id", $id_curso);
        $sql->execute();
        if($sql->rowCount() > 0) {
            $this->info = $sql->fetch();
            
        }  

    }

    public function getNome(){
        return $this->info['nome'];
    }

    public function getImagem(){
        return $this->info['imagem'];
    }

    public function getDescricao(){
        return $this->info['descricao'];
    }

    public function getId(){
        return $this->info['id'];
    }

    public function getTotalAulas(){
        $sql = $this->pdo->prepare("SELECT id FROM aulas WHERE id_curso = :id_curso");
        $sql->bindValue(":id_curso", $this->getId());
        $sql->execute();

        return $sql->rowCount();
    }
}