<div class="admin-layout_header a-header">

    <? include_once ROOT . '/app/view/components/adminPanel/adminPanel.php'; ?>

    <div class="a-header-main">

        <div class="burger">
            <?= \app\view\components\Icon\Icon::gamburger() ?>
        </div>

        <a class="logo" href="/" title="На главную">
            <?= \app\view\components\Icon\Icon::logo_square1() ?>
            <?= \app\view\components\Icon\Icon::logo_vitex_full() ?>
        </a>

        <?= $searchPanel; ?>

        <div class="utils">
            <?= $feedback ?? ''; ?>
            <?= $searchButton; ?>
        </div>

        <!--	<a title="Whatsapp" href="whatsapp://send?phone=79814362309"><img src="/pic/WhatsApp.jpg" alt="Написать в Whatsapp" /></a>-->
        <?= $userMenu; ?>

    </div>
</div>
