
>

<?php if (isset($librerias_css)): ?>
    <?php foreach($librerias_css as $libreria_css): ?>
        <link href="<?php echo  BASE_URL.$libreria_css; ?>" rel="stylesheet" type="text/css">
    <?php endforeach; ?>
<?php endif; ?>


<?php if (isset($ficheros_css)): ?>
    <?php foreach($ficheros_css as $fichero_css): ?>
        <link href="<?php echo  BASE_URL.$fichero_css; ?>" rel="stylesheet" type="text/css">
    <?php endforeach; ?>
<?php endif; ?>