<!DOCTYPE html>
<html>
<!--ADMIN-LAYOUT-->
<head>
    <meta name="token" content="<?= $_SESSION['token'] ?>">
    <meta name="robots" content="noindex,nofollow"/>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="/public/favicon.ico" type="image/x-icon">
    <? $this::getCSS() ?>
    <!--<script>document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')</script>-->
</head>

<body>


<div class="admin-layout__container">

    <? include ROOT . '/app/view/components/admin_menu/admin_menu__accordion.php'; ?>

    <div class="admin-layout__content">

        <? include ROOT . '/app/view/components/header/top_admin.php'; ?>
        <hr>
        <?= $content ?>

    </div>
</div>


<!--<footer></footer>-->


<? $this::getJS() ?>


</body>
</html>