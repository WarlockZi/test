<?php use \app\core\Auth; ?>
<?php if (\app\core\Auth::isAdmin()): ?>
    <div class="admin-panel">

        <?php if (Auth::isSU()): ?>
            <div class="row">
                <a href="/Zip/importfiles">download</a>
                <a href="/adminsc/sync"> Sync</a>
            </div>
        <?php endif; ?>

        <?php if (Auth::isOlya()): ?>
            <div class="row">
                <a href="/adminsc/report/productsNoImgInstore">без картинок</a>
                <a href="/adminsc/report/Productsnominimumunit">без мин упак</a>
                <a href="/adminsc/report/Productsnodopunit">без мин единицы</a>
            </div>
        <?php endif; ?>

    </div>
<?php endif; ?>