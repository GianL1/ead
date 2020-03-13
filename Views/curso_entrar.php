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

</div>