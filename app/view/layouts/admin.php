<!DOCTYPE html>
<html lang="ru">
<!--ADMI N-LAYOUT-->
<head>
    <meta name="phpSession" content="<?= $_SESSION['phpSession'] ?? ''; ?>">
    <meta name="robots" content="noindex,nofollow"/>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?=$assets->icon();?>

    <script type="module" src="https://localhost:5173/@vite/client"></script>
    <script type="module" src="https://localhost:5173/Admin/admin.js"></script>
<!--    --><?php //= $assets->getCss() ?>

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

<?php //= $footer; ?>

<?= $assets->getJs() ?>


</body>

</html>