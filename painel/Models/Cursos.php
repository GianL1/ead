<?php 

namespace Models;

use \Core\Model;

class Cursos extends Model {

    

    public function getCursos(){
        $array = array();

        $sql = $this->pdo->query("SELECT 
        *, (select count(*) from aluno_curso where aluno_curso.id_curso = cursos.id) as qt_alunos 
        FROM cursos");

        if($sql->rowCount() > 0) {
            $array = $sql->fetchAll();
        }

        return $array;
    }

    public function excluirCurso($id_curso){
        
        $sql = $this->pdo->prepare("SELECT id FROM aulas WHERE id_curso = :id_curso");
        $sql->bindValue(":id_curso", $id_curso);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $aulas = $sql->fetchAll();
            foreach($aulas as $aula) {

                $sqlaula = $this->pdo->prepare("DELETE FROM historico WHERE id_aula = :id_aula");
                $sqlaula->bindValue(":id_aula", $aula['id_aula']);
                $sql->execute();

                $sqlaula = $this->pdo->prepare("DELETE FROM questionarios WHERE id_aula = :id_aula");
                $sqlaula->bindValue(":id_aula", $aula['id_aula']);
                $sql->execute();

                $sqlaula = $this->pdo->prepare("DELETE FROM videos WHERE id_aula = :id_aula");
                $sqlaula->bindValue(":id_aula", $aula['id_aula']);
                $sql->execute();
            }
        }

        $sql = $this->pdo->prepare("DELETE FROM cursos WHERE id = :id_curso");
        $sql->bindValue(":id_curso", $id_curso);
        $sql->execute();

        $sql = $this->pdo->prepare("DELETE FROM aluno_curso WHERE id_curso = :id_curso");
        $sql->bindValue(":id_curso", $id_curso);
        $sql->execute();

        $sql = $this->pdo->prepare("DELETE FROM aulas WHERE id_curso = :id_curso");
        $sql->bindValue(":id_curso", $id_curso);
        $sql->execute();

        $sql = $this->pdo->prepare("DELETE FROM modulos WHERE id_curso = :id_curso");
        $sql->bindValue(":id_curso", $id_curso);
        $sql->execute();
    }

    public function adicionarCurso($nome, $descricao = null, $md5name){
        $sql = $this->pdo->prepare("INSERT INTO cursos SET nome = :nome, descricao = :descricao, imagem =:imagem");
        $sql->bindValue(":nome", $nome);
        $sql->bindValue(":descricao", $descricao);
        $sql->bindValue(":imagem", $md5name);
        $sql->execute();
    }

    public function getCurso($id_curso) {
        $array = array();

        $sql = $this->pdo->prepare("SELECT * FROM cursos WHERE id = :id");
        $sql->bindValue(":id", $id_curso);
        $sql->execute();

        if($sql->rowCount() > 0 ) {
            $array = $sql->fetch();
        }

        return $array;
    }

    public function editarCurso($nome, $descricao, $imagem, $id_curso) {
        $sql = $this->pdo->prepare("UPDATE cursos SET nome = :nome, descricao = :descricao WHERE id = :id_curso");
        $sql->bindValue(":nome", $nome);
        $sql->bindValue(":descricao", $descricao);
        $sql->bindValue(":id_curso", $id_curso);
        $sql->execute();

        if(!empty($imagem['tmp_name'])) {
            $md5name = md5(time()).'.jpg';
            $types = array('image/jpeg', 'image/jpg', 'image/png');

            if(in_array($imagem['type'],  $types)) {
                move_uploaded_file($imagem['tmp_name'], "../Assets/Images/cursos/".$md5name);

                    $sql = $this->pdo->prepare("SELECT imagem FROM cursos WHERE id = :id_curso");
                    $sql->bindValue(":id_curso", $id_curso);
                    $sql->execute();

                    if($sql->rowCount() > 0) {
                        $imagem = $sql->fetch();
                        
                        unlink("../Assets/Images/cursos/".$imagem['imagem']);
                    }

                    $sql = $this->pdo->prepare("UPDATE cursos SET imagem = :imagem WHERE id =:id_curso");
                    $sql->bindValue(":imagem", $md5name);
                    $sql->bindValue(":id_curso", $id_curso);
                    $sql->execute();
            }
        }
    }

    public function getCursosInscritos($id_aluno) {
        $array = array();
        $sql = $this->pdo->prepare("SELECT id_curso FROM aluno_curso WHERE id_aluno = :id_aluno");
        $sql->bindValue(":id_aluno", $id_aluno);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $rows = $sql->fetchAll();

            foreach ($rows as $row) {
                $array[] = $row['id_curso'];
            }
        }

        return $array;
    }

}