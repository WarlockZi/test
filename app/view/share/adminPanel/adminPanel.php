<? if (\app\core\Auth::isAdmin()): ?>
    <div class="admin-panel">
        <div class="download-sync">
            <a href="/adminsc/sync/download">download</a>
        </div>
    </div>
<? endif; ?>