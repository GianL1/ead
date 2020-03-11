<h1>Alunos</h1>

<a href="<?php echo BASE_URL?>alunos/adicionar">Adicionar Aluno</a><br>
<table width="100%" border="0">
    <tr>
        <th>Nome</th>
        <th width="80">Qt. de Cursos</th>
        <th  width="200"> Ações</th>
    </tr>
    <?php foreach($alunos as $aluno): ?>
    <tr>
    
        <td><?php echo $aluno['nome']; ?></td>
        <td align="center"><?php echo $aluno['qt_cursos']; ?></td>
        <td>
            <a href="<?php echo BASE_URL?>alunos/editar/<?php echo $aluno['id']; ?>">Editar Aluno</a> - 
            <a href="<?php echo BASE_URL?>alunos/excluir/<?php echo $aluno['id']; ?>">Excluir Aluno</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>