<h1>Editar Curso</h1>

<form action="" method="post" enctype="multipart/form-data">
    <label>
        Nome do Curso: <br>
        <input type="text" name="nome" value="<?php echo $cursos['nome']; ?>"><br><br>
    </label>

    <label>
        Descrição: <br>
        <textarea name="descricao"><?php echo $cursos['descricao']; ?></textarea><br><br>
    </label>

    <label>
        Imagem: <br>
        <input type="file" name="imagem"><br><br>
        <img src="<?php echo BASE_URL; ?>../Assets/Images/cursos/<?php echo $cursos['imagem']; ?>" border="0" height="80">
    </label>
    <button type="submit">Salvar</button>
</form>

<hr>

<h1>Aulas</h1>

<fieldset>
    <legend>Adicionar Modulo Novo</legend>

    <form action="" method="post">
        Nome do Modulo: <br>
        <input type="text" name="modulo" id="">
        <button type="submit">Adicionar Modulo</button>
    </form>
</fieldset>

<br>

<fieldset>
    <legend>Adicionar Aula Nova</legend>

    <form action="" method="post">
        Nome da Aula: <br>
       <input type="text" name="nome_aula" id=""><br><br>

        Titulo da Aula: <br>
       <select name="modulo_aula" id="">
            <?php foreach($modulos as $modulo): ?>
                <option value="<?php echo $modulo['id'];?>"><?php echo $modulo['nome'];?></option>
            <?php endforeach; ?>
       </select><br><br>
        
        Tipo da Aula: <br>
       <select name="tipo" id="">
                <option value="1">Vídeo</option>
                <option value="2">Questionário</option>
       </select><br><br>
       <button type="submit">Adicionar Aula</button>
    </form>
</fieldset>

<?php foreach($modulos as $modulo): ?>
    <h4>
        <?php echo $modulo['nome']?> - 
        <a href="<?php echo BASE_URL;?>home/del_modulo/<?php echo $modulo['id'];?>"> [ Excluir ] </a>
         - <a href="<?php echo BASE_URL;?>home/edit_modulo/<?php echo $modulo['id'];?>">Editar Modulo</a>
    </h4>

    <?php foreach($modulo['aulas'] as $aula): ?>
        
        <h5><?php echo $aula['nome']; ?> - <a href="">[editar]</a> - 
            <a href="<?php echo BASE_URL;?>home/del_aula/<?php echo $aula['id'];?>">[ Excluir ]</a>
        </h5>
    <?php endforeach; ?>

<?php endforeach; ?>