<? if (\app\core\Auth::isAdmin()): ?>
    <div class="admin-panel">
        <div class="download-sync">
            <a href="/Zip/importfiles">download</a>
        </div>
    </div>
<? endif; ?>