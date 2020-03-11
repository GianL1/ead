<?php

namespace Models;

use \Core\Model;

class Alunos extends Model {

    public function getAlunos(){
        $array = array();
        $sql = $this->pdo->query("SELECT 
        *, (select count(*) from aluno_curso where aluno_curso.id_aluno = alunos.id) as qt_cursos 
        FROM alunos");

        if($sql->rowCount() > 0) {
            $array = $sql->fetchAll();
        }

        return $array;
    }

    public function excluirAluno($id){
        

        $sql = $this->pdo->prepare("DELETE FROM aluno_curso WHERE id_aluno = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        $sql = $this->pdo->prepare("DELETE FROM alunos WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        header("Location".BASE_URL."alunos");
    }

    public function adicionarAluno($nome, $email, $senha){
        $sql = $this->pdo->prepare("INSERT INTO alunos SET nome = :nome, email = :email, senha = :senha");
        $sql->bindValue(":nome", $nome);
        $sql->bindValue(":email", $email);
        $sql->bindValue(":senha", $senha);

        $sql->execute();
    }

    public function getAluno($id_aluno) {
        $array = array();

        $sql = $this->pdo->prepare("SELECT * FROM alunos WHERE id = :id");
        $sql->bindValue(":id", $id_aluno);
        $sql->execute();

        if($sql->rowCount() > 0 ) {
            $array = $sql->fetch();
        }

        return $array;
    }

    public function editarAluno($id, $nome, $email, $senha, $cursos){
        $sql = $this->pdo->prepare("UPDATE FROM alunos SET nome = :nome, email = :email, senha =:senha WHERE id = :id");
        $sql->bindValue(":nome", $nome);
        $sql->bindValue(":email", $email);
        $sql->bindValue(":senha", $senha);
        $sql->execute();

        $sql = $this->pdo->prepare("DELETE FROM aluno_curso WHERE id_aluno = :id_aluno");
        $sql->bindValue(":id_aluno", $id);
        $sql->execute();

        foreach($cursos as $curso) {
            $sql = $this->pdo->prepare("INSERT INTO aluno_curso SET id_aluno = :id_aluno, id_curso = :id_curso");
            $sql->bindValue(":id_aluno", $id);
            $sql->bindValue(":id_curso", $curso);
            $sql->execute();
        }
    }
    
}