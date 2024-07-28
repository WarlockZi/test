<?php use app\core\Auth; ?>
<?php if (Auth::isAdmin()): ?>
    <div class="admin-panel">

        <div class="row">
<!--            <a href="/adminsc/report/productsNoImgInstore">без картинок</a>-->
<!--            <a href="/adminsc/report/Productsnominunit">без мин упак</a>-->
<!--            <a href="/adminsc/report/Productsnoshippable">без мин единицы</a>-->
            <a href="/adminsc/report/filter">фильтры</a>

            <?php if (Auth::isSU(Auth::getUser()['email'])): ?>
                <a href="/zip/download">Download</a>
                <a href="/adminsc/sync"> Sync</a>
            <?php endif; ?>

            <?php if (Auth::isOlya()): ?>
            <?php endif; ?>

        </div>

    </div>
<?php endif; ?>