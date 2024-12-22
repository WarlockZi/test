<!DOCTYPE html>
<html>
<!--ADMIN-LAYOUT-->
<head>
    <meta name="phpSession" content="<?= $_SESSION['phpSession'] ?? ''; ?>">
    <meta name="robots" content="noindex,nofollow"/>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/logo-square.svg" type="image/svg+xml">

    <?= $assets->getCss() ?>

</head>

<body class="preload">

<div class="admin-layout">

    <?= $header; ?>

    <div class="admin-layout_content content">

        <div class="adm-content">
            <?= $errors; ?>
            <?= $content; ?>
        </div

    </div>

<!--    <div class="led"></div>-->
</div>

<?= $footer; ?>

<?= $assets->getJs() ?>


</body>

</html>