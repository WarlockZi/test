<header class="burger">
    @include('layouts.main.header.adminPanel')
    <div class="info" itemscope itemtype="https://schema.org/Organization">

        <div class="column none">
            <h3>Компания</h3>
            <p itemprop="name">Витекс</p>
        </div>


    @include('layouts.main.header.info.logo')
    @include('layouts.main.header.info.phone')
    @include('layouts.main.header.info.location')
    @include('layouts.main.header.info.call_me')
    @include('layouts.main.header.info.user_menu')

    </div>

    @include('layouts.main.header.blueRibbon.index')


</header>

