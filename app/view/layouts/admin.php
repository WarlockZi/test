<?php

use app\core\Error;

//require_once __DIR__ . '/helpers.php';
?>
<!DOCTYPE html>
<html>
<!--ADMIN-LAYOUT-->
<head>
    <meta name="token" content="<?= $_SESSION['token'] ?>">
    <meta name="robots" content="noindex,nofollow"/>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/logo-square.svg" type="image/svg+xml">

    <?= $assets->getCss() ?>
    <?= $assets->getCDNCss() ?>

</head>

<body>
<? include_once  dirname(__DIR__).'/share/adminPanel/adminPanel.php';?>

<div class="admin-layout__container">

    <?= $header; ?>

    <div class="admin-layout__content">

        <div class="adm-content">
            <?= $errors; ?>
            <?= $content; ?>
        </div

    </div>

    <div class="led"></div>
</div>

<?= $footer; ?>

<?= $assets->getJs() ?>
<?= $assets->getCDNJs() ?>

</body>
</html>