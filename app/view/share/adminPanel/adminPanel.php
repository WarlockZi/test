<? if (\app\core\Auth::isAdmin()): ?>
    <div class="admin-panel">
        <div class="download-sync">
            <a href="/Zip/importfiles">download</a>
            <a href="/adminsc/sync"> Sync</a>
        </div>
    </div>
<? endif; ?>