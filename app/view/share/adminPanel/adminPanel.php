<?php use app\core\Auth; ?>
<?php if (Auth::getUser()?->isAdmin()): ?>
    <div class="admin-panel">

        <div class="row">
            <a href="/adminsc/report/filter">фильтры</a>

            <?php if (Auth::getUser()->isSU()): ?>
                <a href="/zip/download">Download</a>
                <a href="/adminsc/sync"> Sync</a>
            <?php endif; ?>

            <?php if (Auth::getUser()->isOlya()): ?>
            <?php endif; ?>

        </div>

    </div>
<?php endif; ?>