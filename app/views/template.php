<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link id="style" href="<?php echo $_ENV['URL_BASE']; ?>/assets/bootstrap-5.2.3-dist/css/bootstrap.min.css" rel="stylesheet" />
    <link id="style" href="<?php echo $_ENV['URL_BASE']; ?>/assets/css/style.css" rel="stylesheet" />

    <?php echo vite('main.js') ?>
</head>
<body>

<?php 


$this->loadView($viewName, $viewData); 

?>


<script src="<?php echo $_ENV['URL_BASE']; ?>/assets/bootstrap-5.2.3-dist/js/bootstrap.bundle.min.js"  crossorigin="anonymous"></script>


</body>
</html>