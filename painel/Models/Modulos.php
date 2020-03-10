<?php 

namespace Models;

use \Core\Model;
use \Models\Aulas;

class Modulos extends Model {

    public function getModulos($id_curso){
        $array = array();
        $sql = $this->pdo->prepare("SELECT * FROM modulos WHERE id_curso = :id_curso");
        $sql->bindValue(":id_curso",$id_curso);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $array = $sql->fetchAll();
            $aulas = new Aulas();

            foreach($array as $mChave => $mDados) {
                $array[$mChave]['aulas'] = $aulas->getAulasDoModulo($mDados['id']);
            }
        }
        return $array;
        
    }

    public function adicionarModulo($modulo, $id_curso){
       $sql = $this->pdo->prepare("INSERT INTO modulos SET id_curso = :id_curso, nome = :nome");
       $sql->bindValue(":nome", $modulo) ;
       $sql->bindValue(":id_curso",$id_curso);
       $sql->execute();
    }

    public function deletarModulo($id_modulo){
        $sql = $this->pdo->prepare("DELETE FROM modulos WHERE id = :id_modulo");
        $sql->bindValue(":id_modulo", $id_modulo);
        $sql->execute();
    }

    public function getModulo($id_modulo){
        $array = array();

        $sql = $this->pdo->prepare("SELECT * FROM modulos WHERE id = :id_modulo");
        $sql->bindValue(":id_modulo", $id_modulo);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $array = $sql->fetch();
        }
        
        return $array;
    }

    public function editarModulo($nome, $id_modulo){
        $sql = $this->pdo->prepare("UPDATE modulos SET nome = :nome WHERE id = :id_modulo");
        $sql->bindValue(":nome", $nome);
        $sql->bindValue(":id_modulo", $id_modulo);
        $sql->execute();
    }
}