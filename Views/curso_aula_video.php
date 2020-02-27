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
            <h1>Vídeo - <?php echo $aula_info['nome']; ?></h1>
            <iframe id="video" src="//player.vimeo.com/video/336611193" frameborder="0" style="width:100%"></iframe><br>
            <?php echo $aula_info['descricao']; ?><br>
            
            <?php if ($aula_info['assistido'] == '1'): ?>
                Você já assistiu essa aula
            <?php else: ?>
                <button onclick="marcarAssistido(this)" data-id="<?php echo $aula_info['id_aula']; ?>">Marcar como assistido</button>
            <?php endif; ?>
            <hr>
            <h3>Dúvidas ? Envie sua pergunta</h3>

            <form action="" method="post" class="form_duvida">
                <textarea name="duvida" id="" cols="60" rows="10"></textarea><br><br>
                <button type="submit">Enviar</button>
            </form>
</div>