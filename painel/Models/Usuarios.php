<?php 

namespace Models;

use \Core\Model;

class Usuarios extends Model {
    private $info;

    public function isLogged(){
        if(isset($_SESSION['lgadmin']) && !empty($_SESSION['lgadmin'])) {
            return true;
        }else {
            return false;
        }
    }

    public function fazerLogin($email, $senha){
        $sql = $this->pdo->prepare("SELECT * FROM usuarios WHERE email = :email AND senha = :senha");
        $sql->bindValue(":email", $email);
        $sql->bindValue(":senha", $senha);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $row = $sql->fetch();
            $_SESSION['lgadmin'] = $row['id'];

            return true;
        }else {
            return false;
        }
    }

    
}