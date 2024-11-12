<?php

use app\core\Icon;

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <!--	VITEX-LAYOUT-->
    <meta charset="utf-8">
    <meta name="phpSession" content="<?= $_SESSION['phpSession'] ?? ''; ?>">
    <meta http-equiv="cleartype" content="on"/>
    <meta name="MobileOptimized" content="320">
    <meta name="HandheldFriendly" content="True">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="yandex-verification" content="127ee751f73e25e0"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../../../pic/srvc/<?= DEV ? "logo-square-dev.svg" : "logo-square.svg" ?>" type=" image
    /svg+xml">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
          rel="stylesheet">


    <script src="https://yastatic.net/s3/passport-sdk/autofill/v1/sdk-suggest-with-polyfills-latest.js"></script>
    <script src="https://yastatic.net/s3/passport-sdk/autofill/v1/sdk-suggest-token-with-polyfills-latest.js"></script>
    <?= $assets->getMeta(); ?>

    <?= $assets->getCss(); ?>

</head>

<? include_once __DIR__ . '/google.php'; ?>
<body>

<?= $header; ?>


<div class="user-content-wrap">
    <main class="user-content">

        <?= $content; ?>
    </main>
    <div class="hoist">Наверх</div>
</div>

<?= $footer; ?>

<?= $assets->getJs(); ?>

<?php //= $assets->getCDNJs(); ?>

<div class="modal invisible" data-modal="default">
    <div class="overlay"></div>
    <div class="wrap">
        <div class="box">
            <div class="title">Заголовок</div>
            <div class="modal-close"><?= Icon::close() ?></div>
            <div class="content"></div>
        </div>
    </div>

</div>

</body>
</html>