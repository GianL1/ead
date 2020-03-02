<h1>Editar Curso</h1>

<form action="" method="post" enctype="multipart/form-data">
    <label>
        Nome do Curso: <br>
        <input type="text" name="nome" value="<?php $curso['nome']?>"><br><br>
    </label>

    <label>
        Descrição: <br>
        <textarea name="descricao"><?php $curso['nome']?></textarea><br><br>
    </label>

    <label>
        Imagem: <br>
        <input type="file" name="imagem"><br><br>
        <img src="<?php echo BASE_URL; ?>../Assets/Images/curso/<?php echo $curso['imagem']; ?>" border="0" height="80">
    </label>
    <button type="submit">Adicionar Curso</button>
</form>