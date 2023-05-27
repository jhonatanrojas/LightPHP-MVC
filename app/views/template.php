<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php $debugbarRenderer = $this->getJavascriptRenderer('/appSocialMediaRestaurantGPT/backend/'); ?>
   
</head>
<body>
<?php $this->loadView($viewName, $viewData); ?>
<?php  header('Content-Type', 'text/javascript');
$debugbarRenderer->dumpJsAssets(); ?>
<?php echo $debugbarRenderer->renderHead() ?>
<?php echo $debugbarRenderer->render() ?>

</body>
</html>