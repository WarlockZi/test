<div class="admin-layout_header a-header">

    @include('layouts.admin.header.adminPanel')

    <div class="a-header-main">

        <div class="burger">
            <?= \app\view\components\Icon\Icon::gamburger() ?>
        </div>

        <a class="logo" href="/" title="На главную">
            <?= \app\view\components\Icon\Icon::logo_square1() ?>
            <?= \app\view\components\Icon\Icon::logo_vitex_full() ?>
        </a>

        @include('layouts.admin.header.blueRibbon.search_panel')

        <div class="utils">
            @include('layouts.admin.header.blueRibbon.search_button')
            @include('layouts.admin.header.blueRibbon.feedback')
        </div>

        <!--	<a title="Whatsapp" href="whatsapp://send?phone=79814362309"><img src="/pic/WhatsApp.jpg" alt="Написать в Whatsapp" /></a>-->
        @include('layouts.admin.header.blueRibbon.user_menu')

    </div>
</div>
