@php
    use app\view\components\Icon\Icon;
//    xdebug_break();
@endphp

@include('layouts.admin.header.admin_menu_accordion')

<div class="admin-layout_header a-header">

    @include('layouts.admin.header.adminPanel')

    <div class="a-header-main">

        <div class="burger">
            <?= Icon::gamburger() ?>
        </div>

        <a class="logo" href="/" title="На главную">
            <?= Icon::logo_square1() ?>
            <?= Icon::logo_vitex_full() ?>
        </a>

        @include('layouts.admin.header.search_panel')

        <div class="utils">
            @include('layouts.admin.header.search_button')
            @include('layouts.admin.header.feedback')
        </div>

        <!--	<a title="Whatsapp" href="whatsapp://send?phone=79814362309"><img src="/pic/WhatsApp.jpg" alt="Написать в Whatsapp" /></a>-->
        @include('layouts.admin.header.user_menu')

    </div>
</div>
