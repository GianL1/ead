<h1>Editar Aula</h1>

<fieldset>
    <form action="" method="post">
        Titulo da Aula: <br>
        <input type="text" name="nome" value="<?php echo $aula['nome']; ?>"><br><br>

        Descrição da Aula: <br>
        <textarea name="descricao" id="" cols="30" rows="10"><?php echo $aula['descricao']; ?></textarea><br><br>

        URL do Vídeo: <br>
        <input type="text" name="url" id="" value="<?php echo $aula['url']; ?>" >
        
        <button type="submit">Salvar</button>
    </form>
</fieldset>