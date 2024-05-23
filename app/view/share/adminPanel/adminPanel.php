<? if (\app\core\Auth::isAdmin()): ?>
    <div class="admin-panel">
        <div class="download-sync">

            <a href="/app/Storage/import/import0_1.xml"
               target="_blank"
               download="import"
            >imp</a>
            <a href="/app/Storage/import/offers0_1.xml"
               target="_blank"
               download="offers"
            >off</a>
        </div>

    </div>
<? endif; ?>