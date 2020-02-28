<?php

namespace Controllers;

use \Core\Controller;
use \Models\Usuarios;

class LoginController extends Controller { 

    public function index(){
        $array = array();

        if(isset($_POST['email']) && !empty($_POST['email'])) {
            $email = addslashes($_POST['email']);
            $senha = md5($_POST['senha']);
 
            $usuarios = new Usuarios();

            if($usuarios->fazerLogin($email, $senha)){
                header("Location:".BASE_URL);
            }
         }

        $this->loadView('login', $array);
    }

    public function logout(){
        unset($_SESSION['lgadmin']);
    }
}