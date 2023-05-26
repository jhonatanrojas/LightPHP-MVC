



    <script type="text/javascript" >
        var BASE_URL ="<?php echo BASE_URL ?>" 

    </script>


<?php if (isset($librerias_js)): ?>
<?php foreach($librerias_js as $libreria_js): ?>
    <script type="text/javascript" src="<?php echo  BASE_URL.$libreria_js; ?>"></script>
<?php endforeach; ?>
<?php endif; ?>

<?php if (isset($constantes_js) && $constantes_js && count($constantes_js)): ?>
<script type="text/javascript">
    <?php foreach ($constantes_js as $constante_js => $valor_constante_js): ?>
        <?php if (is_numeric($valor_constante_js)): ?>
            const <?php echo $constante_js ?> = <?php echo $valor_constante_js ?>;
        <?php else: ?>
            const <?php echo $constante_js ?> = '<?php echo $valor_constante_js ?>';
        <?php endif; ?>
    <?php endforeach; ?>
</script>
<?php endif; ?>


<?php if (isset($ficheros_js)): ?>
    <?php foreach($ficheros_js as $fichero_js): ?>
        <script type="text/javascript" src="<?php echo BASE_URL.$fichero_js; ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>