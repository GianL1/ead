<?php 

namespace Models;
use \Core\Model;

class Aulas extends Model {
    public function getAulasDoModulo($id_modulo){
        $array = array();
        $aluno = $_SESSION['lgaluno'];

        $sql = $this->pdo->prepare("SELECT *, aulas.id as id_aula FROM aulas WHERE id_modulo = :id_modulo ORDER BY ordem");
        $sql->bindValue(":id_modulo", $id_modulo);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $array = $sql->fetchAll();
            
            foreach($array as $aulaChave => $aula) {
                $array[$aulaChave]['assistida'] = $this->isAssistido($aula['id'], $aluno);
                
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

        $id_aluno = $_SESSION['lgaluno'];

        $sql = $this->pdo->prepare("SELECT tipo, id as id_aula, 
                                    (select count(*) from historico where historico.id_aula = aulas.id and historico.id_aluno = :id_aluno) as assistido 
                                    FROM aulas WHERE id = :id_aula");
        $sql->bindValue(":id_aula", $id_aula);
        $sql->bindValue(":id_aluno", $id_aluno);
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
            
            $array['assistido'] = $row['assistido'];
            
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

    private function isAssistido($id_aula, $id_aluno){
        $sql = $this->pdo->prepare("SELECT id FROM historico WHERE id_aluno = :id_aluno AND id_aula = :id_aula");
        $sql->bindValue(":id_aluno", $id_aluno);
        $sql->bindValue(":id_aula", $id_aula);
        $sql->execute();

        if($sql->rowCount() > 0) {
            return true;
        }else {
            return false;
        }
    }
}