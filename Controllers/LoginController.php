<?php

namespace Controllers;

use \Core\Controller;
use \Models\Alunos;

class LoginController extends Controller { 

    public function index(){
        $array = array();

        if(isset($_POST['email']) && !empty($_POST['email'])) {
            $email = addslashes($_POST['email']);
            $senha = md5($_POST['senha']);
 
            $alunos = new Alunos();

            if($alunos->fazerLogin($email, $senha)){
                header("Location:".BASE_URL);
            }
         }

        $this->loadView('login', $array);
    }

    public function logout(){
        unset($_SESSION['lgaluno']);
    }
}