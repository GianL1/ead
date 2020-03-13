<?php

namespace Models;

use \Core\Model;

class Alunos extends Model {

    private $info;

    public function isLogged(){
        if(isset($_SESSION['lgaluno']) && !empty($_SESSION['lgaluno'])) {
            return true;
        }else {
            return false;
        }
    }

    public function fazerLogin($email, $senha){
        $sql = $this->pdo->prepare("SELECT * FROM alunos WHERE email = :email AND senha = :senha");
        $sql->bindValue(":email", $email);
        $sql->bindValue(":senha", $senha);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $row = $sql->fetch();
            $_SESSION['lgaluno'] = $row['id'];

            return true;
        }else {
            return false;
        }
    }

    public function setAluno($id){
        $sql = $this->pdo->prepare("SELECT * FROM alunos WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $this->info = $sql->fetch();
        }
    }

    public function getNome(){
        return $this->info['nome'];
    }

    public function getId(){
        return $this->info['id'];
    }

    public function isInscrito($id_curso) {
        $sql = $this->pdo->prepare("SELECT * FROM aluno_curso WHERE id_aluno =:id_aluno AND id_curso = :id_curso");
        $sql->bindValue(":id_aluno", $this->info['id']);
        $sql->bindValue(":id_curso", $id_curso);
        $sql->execute();

        if($sql->rowCount() > 0) {
            return true;
        }else {
            return false;
        }
    }

    public function getNumAulasAssistidas($id_curso){
        //Seleciona todos os ID de históricos onde o id do Aluno foi o setado e o id da aula estiver naquele determinado curso
        $sql = $this->pdo->prepare("SELECT id FROM historico WHERE id_aluno = :id_aluno AND id_aula IN (select aulas.id from aulas where aulas.id_curso = :id_curso)");
        $sql->bindValue(":id_aluno", $this->getId());
        $sql->bindValue(":id_curso",$id_curso);
        $sql->execute();

        return $sql->rowCount();
    }
}