<div class="cursoinfo">
    <img src="<?php echo BASE_URL; ?>Assets/Images/curso/<?php echo $curso->getImagem();?>" alt="" height="60" border="0">

    <h3><?php echo $curso->getNome(); ?></h3>
    <?php echo $curso->getDescricao(); ?>
</div>

<div class="curso_left">
    <?php foreach($modulos as $modulo): ?>
        <div class="modulo">
            <?php echo $modulo['nome']; ?>
        </div>

        <?php foreach($modulo['aulas'] as $aula): ?>
        
            <div class="aula">
                <a href="<?php echo BASE_URL?>cursos/aula/<?php echo $aula['id_aula']?>"><?php echo $aula['nome']; ?></a>
            </div>
        <?php endforeach; ?>
    <?php endforeach; ?>
</div>
<div class="curso_right">

</div>