<h1>Cursos</h1>
<a href="<?php echo BASE_URL?>home/adicionar">Adicionar Curso</a><br>
<table width="100%" border="0">
    <tr>
        <th>Imagem</th>
        <th>Nome</th>
        <th width="80">Qt. de Alunos</th>
        <th  width="200"> Ações</th>
    </tr>
    <?php foreach($cursos as $curso): ?>
    <tr>
        <td width="120"><img src="<?php echo BASE_URL; ?>../Assets/Images/cursos/<?php echo $curso['imagem'];?>" border="0" height="70"  ></td>
        <td><?php echo $curso['nome']; ?></td>
        <td align="center"><?php echo $curso['qt_alunos']; ?></td>
        <td>
            <a href="<?php echo BASE_URL?>home/editar/<?php echo $curso['id']; ?>">Editar Curso</a> - 
            <a href="<?php echo BASE_URL?>home/excluir/<?php echo $curso['id']; ?>">Excluir Curso</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>