<h1>Seus Cursos</h1>

<?php foreach($cursos as $curso): ?>
    
        <div class="cursoitem">
            <a href="<?php echo BASE_URL; ?>cursos/entrar/<?php echo $curso['id_curso'];?>">
                <img src="<?php echo BASE_URL; ?>Assets/Images/cursos/<?php echo $curso['imagem']; ?>" border=0 width="260" height="150"><br><br>

                <strong><?php echo $curso['nome']; ?></strong><br><br>
                <?php echo $curso['descricao']; ?>
            </a>
        </div>
    
<?php endforeach; ?>