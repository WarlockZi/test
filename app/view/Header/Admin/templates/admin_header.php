<div class="admin-layout_header a-header">

    <? include_once ROOT . '/app/view/share/adminPanel/adminPanel.php'; ?>

    <div class="relative">

        <?= $logo; ?>

        <?= $searchPanel; ?>
        <div class="utils">


            <?= $feedback??''; ?>
            <?= $searchButton; ?>
        </div>

        <!--	<a title="Whatsapp" href="whatsapp://send?phone=79814362309"><img src="/pic/WhatsApp.jpg" alt="Написать в Whatsapp" /></a>-->
        <?= $userMenu; ?>
    </div>
</div>
