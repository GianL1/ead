<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo BASE_URL;?>../Assets/css/style.css">
    <script type="text/javascript" src="<?php echo BASE_URL;?>../Assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL;?>../Assets/js/script.js"></script>
    <title>Sistema EAD</title>
</head>
<body>
    <div class="topo">
        <a href="<?php echo BASE_URL?>/login/logout">
            <div>Sair</div>
        </a>
        
    </div>
    <?php $this->loadViewInTemplate($viewName, $viewData); ?>
</body>
</html>