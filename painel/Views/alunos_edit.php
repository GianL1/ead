<h1>Adicionar Aluno</h1>

<form action="" method="post">
    <label>
        Nome do Aluno: <br>
        <input type="text" name="nome" value="<?php echo $aluno['nome'];?>"><br><br>
    </label>

    <label>
        Email: <br>
        <input type="email" name="email" value="<?php echo $aluno['email'];?>"><br><br>
    </label>

    <label>
        Senha: <br>
        <input type="password" name="senha" value="<?php echo $aluno['senha'];?>"><br>
    </label>

    <label>
        Cursos Inscritos (Segure CTRL para selecionar outros cursos)<br>
        <select name="cursos[]" id="" multiple style="height:150px">
            <?php foreach($cursos as $curso): ?>
                <option value="<?php echo $curso['id']; ?>"<?php 
                if(in_array($curso['id'],$inscrito)){
                    echo 'selected="selected"';
                }
                ?>><?php echo $curso['nome']; ?></option>
            <?php endforeach; ?>
        </select><br><br>
    </label>

    <button type="submit">Salvar</button>
</form>