<div class="cursoinfo">
    <img src="<?php echo BASE_URL; ?>Assets/Images/curso/<?php echo $curso->getImagem();?>" alt="" height="60" border="0">

    <h3><?php echo $curso->getNome(); ?></h3>
    <?php echo $curso->getDescricao(); ?><br>
    <?php echo $aulas_assistidas.'/'. $total_de_aulas.' ('.(($aulas_assistidas/$total_de_aulas)*100).'%)' ;?>
</div>

<div class="curso_left">
    <?php foreach($modulos as $modulo): ?>
        <div class="modulo">
            <?php echo $modulo['nome']; ?>
        </div>

        <?php foreach($modulo['aulas'] as $aula): ?>
            <div class="aula">
                <a href="<?php echo BASE_URL?>cursos/aula/<?php echo $aula['id_aula']?>"><?php echo $aula['nome']; ?></a>
                <?php if($aula['assistida'] == true): ?>
                    <img style="float:right;margin-right:10px;margin-top:5px"src="<?php echo BASE_URL?>Assets/Images/v.png" height="20px"alt="">
                <?php else: 
                    echo "(NÃO)";
                ?>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php endforeach; ?>
</div>
<div class="curso_right">
            <h1>Questionário</h1>
            <h3><?php echo $aula_info['pergunta'];?></h3>

            <?php if($_SESSION['poll'.$aula_info['id_aula']] >2) {
                echo "Você atingiu o limite de tentativas"; }  
                else{
                    echo 'Tentativa '.$_SESSION['poll'.$aula_info['id_aula']]. ' de 2'; 

            
            ?>

                    <form action="" method="post">
                        <label>
                            Opção 1 
                            <input type="radio" name="opcao" value="1"><br>
                        </label>

                        <label>
                            Opção 2 
                            <input type="radio" name="opcao" value="2"><br>
                        </label>

                        <label>
                            Opção 3 
                            <input type="radio" name="opcao" value="3"><br>
                        </label>

                        <label>
                            Opção 4 
                            <input type="radio" name="opcao" value="4"><br>
                        </label><br>

                        <button type="submit">Enviar Resposta</button>
                    </form>

                <?php } ?>
                
        

           <?php if(isset($resposta)){
                    if($resposta === true) {
                        echo "RESPOSTA CORRETA";
                    }else {
                        echo "RESPOSTA ERRADA";
                    }
                }

           ?>
</div>