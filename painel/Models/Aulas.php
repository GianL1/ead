<?php 

namespace Models;
use \Core\Model;

class Aulas extends Model {
    public function getAulasDoModulo($id_modulo){
        $array = array();

        $sql = $this->pdo->prepare("SELECT *, aulas.id as id_aula FROM aulas WHERE id_modulo = :id_modulo ORDER BY ordem");
        $sql->bindValue(":id_modulo", $id_modulo);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $array = $sql->fetchAll();
            
            foreach($array as $aulaChave => $aula) {
                if($aula['tipo'] == 1) {
                    $id = $aula['id'];
                    $sql = $this->pdo->query("SELECT nome FROM videos WHERE id_aula = $id")->fetch();

                    $array[$aulaChave]['nome'] = $sql['nome'];
                }else if($aula['tipo'] == 2) {
                    $array[$aulaChave]['nome'] = 'Questionário';
                }
            }
        }

        return $array;
    }

    public function getCursoDeAula($id_aula){
        $array = array();

        $sql = $this->pdo->prepare("SELECT id_curso FROM aulas WHERE id = :id_aula");
        $sql->bindValue(":id_aula", $id_aula);
        $sql->execute();

        if($sql->rowCount() > 0){
            $row= $sql->fetch();
            return $row['id_curso'];    
        }else {
            return 0;
        }
    }

    public function getAula($id_aula){
        $array = array();


        $sql = $this->pdo->prepare("SELECT tipo 
                                    FROM aulas WHERE id = :id_aula");
        $sql->bindValue(":id_aula", $id_aula);
        $sql->execute();

        if($sql->rowCount() > 0)
        {
            
            $row = $sql->fetch();
            

            if($row['tipo'] == 1) {
                $sql = $this->pdo->prepare("SELECT * FROM videos WHERE id_aula = :id_aula");
                $sql->bindValue(":id_aula", $id_aula);
                $sql->execute();

                if($sql->rowCount() > 0) {
                    $array = $sql->fetch();
                    $array['tipo'] = 'video';
                    
                }
            }else if($row['tipo'] == 2){
                $sql = $this->pdo->prepare("SELECT * FROM questionarios WHERE id_aula = :id_aula");
                $sql->bindValue(":id_aula", $id_aula);
                $sql->execute();

                if($sql->rowCount() > 0) {
                    $array = $sql->fetch();
                    $array['tipo'] = 'questionario';
                   
                }
            }
            
        }
        
        return $array;
    }

    public function setDuvida($duvida, $id_aluno){
        $sql = $this->pdo->prepare("INSERT INTO duvidas(data_duvida, duvida, id_aluno) VALUES (NOW(), :duvida, :id_aluno)");
        $sql->bindValue(":id_aluno", $id_aluno);
        $sql->bindValue(":duvida", $duvida);
        $sql->execute();
    }

    public function marcarAssistido($id_aula){
        $sql = $this->pdo->prepare("INSERT INTO historico SET data_viewed = NOW(), id_aluno = :aluno, id_aula =:id");
        $sql->bindValue(":aluno", $_SESSION['lgaluno']);
        $sql->bindValue(":id", $id_aula);
        $sql->execute();
    }

    public function deleteAula($id_aula) {
        $sql = $this->pdo->prepare("DELETE FROM aulas WHERE id = :id_aula");
        $sql->bindValue(":id_aula", $id_aula);
        $sql->execute();

        $sql = $this->pdo->prepare("DELETE FROM questionarios WHERE id_aula = :id_aula");
        $sql->bindValue(":id_aula", $id_aula);
        $sql->execute();

        $sql = $this->pdo->prepare("DELETE FROM videos WHERE id = :id_aula");
        $sql->bindValue(":id_aula", $id_aula);
        $sql->execute();

        $sql = $this->pdo->prepare("DELETE FROM historico WHERE id = :id_aula");
        $sql->bindValue(":id_aula", $id_aula);
        $sql->execute();
    }

    public function addAula($id_curso, $id_modulo, $aula, $tipo){
        $sql = $this->pdo->prepare("SELECT ordem FROM aulas WHERE id_modulo = :id_modulo ORDER BY ordem DESC LIMIT 1");
        $sql->bindValue(":id_modulo", $id_modulo);
        $sql->execute();


        $ordem = 1;

        if($sql->rowCount() > 0) {
            $sql = $sql->fetch();
            $ordem = intval($sql['ordem']);
            $ordem++;  
        }

        $sql = $this->pdo->prepare("INSERT INTO aulas SET id_modulo = :id_modulo, 
        id_curso = :id_curso, 
        ordem = :ordem, tipo = :tipo");
        
        $sql->bindValue(":id_modulo", $id_modulo);
        $sql->bindValue(":id_curso", $id_curso);
        $sql->bindValue(":ordem", $ordem);
        $sql->bindValue(":tipo", $tipo);
        $sql->execute();

        $id_aula = $this->pdo->lastInsertId();

            if($tipo == 'video') {
                $sql = $this->pdo->prepare("INSERT INTO videos SET id_aula = :id_aula, nome = :nome");
                $sql->bindValue(":id_aula", $id_aula);
                $sql->bindValue(":nome", $aula);
                $sql->execute();
            } else {
                $sql = $this->pdo->prepare("INSERT INTO questionarios SET id_aula = :id_aula");
                $sql->bindValue(":id_aula", $id_aula);
                $sql->execute();
            }
    }

    public function updateVideoAula($id_aula, $nome, $descricao, $url) {
        $sql = $this->pdo->prepare("UPDATE videos SET nome = :nome, descricao = :descricao, url =:url WHERE id_aula = :id_aula");
        $sql->bindValue(":nome",$nome);
        $sql->bindValue(":descricao", $descricao);
        $sql->bindValue(":url", $url);
        $sql->bindValue(":id_aula", $id_aula);
        $sql->execute();
    }

    public function updateQuestionarioAula($id_aula, $pergunta, $opcao1, $opcao2, $opcao3, $opcao4, $resposta)
    {
        $sql = $this->pdo->prepare("UPDATE questionarios SET pergunta = :pergunta, opcao1 = :op1, opcao2 = :op2, opcao3 = :op3, opcao4 = :op4, resposta = :resposta 
                                                WHERE id_aula = :id_aula");
        $sql->bindValue(":pergunta", $pergunta);
        $sql->bindValue(":op1", $opcao1);
        $sql->bindValue(":op2", $opcao2);
        $sql->bindValue(":op3", $opcao3);
        $sql->bindValue(":op4", $opcao4);
        $sql->bindValue(":resposta", $resposta);
        $sql->bindValue(":id_aula", $id_aula);
        $sql->execute();
    }
}