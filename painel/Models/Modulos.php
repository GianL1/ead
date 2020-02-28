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
}