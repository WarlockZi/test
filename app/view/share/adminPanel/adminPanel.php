<?php use \app\core\Auth; ?>
<?php if (Auth::isAdmin()): ?>
    <div class="admin-panel">

        <?php if (Auth::isSU(Auth::getUser()['email'])): ?>
            <div class="row">
                <a href="/Zip/importfiles">download</a>
                <a href="/adminsc/sync"> Sync</a>
                <a href="/adminsc/report/productsNoImgInstore">без картинок</a>
                <a href="/adminsc/report/Productsnominunit">без мин упак</a>
                <a href="/adminsc/report/Productsnoshippable">без мин единицы</a>
                <a href="/adminsc/report/ProductsBaseIsShippable">баз = мин </a>
            </div>
        <?php endif; ?>

        <?php if (Auth::isOlya()): ?>
            <div class="row">
                <a href="/adminsc/report/productsNoImgInstore">без картинок</a>
                <a href="/adminsc/report/Productsnominunit">без мин упак</a>
                <a href="/adminsc/report/Productsnoshippable">без мин единицы</a>
                <a href="/adminsc/report/ProductsBaseIsShippable">баз = мин </a>
            </div>
        <?php endif; ?>

    </div>
<?php endif; ?>