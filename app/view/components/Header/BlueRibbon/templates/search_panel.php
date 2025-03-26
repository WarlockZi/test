<?php

use app\Services\Icon;

?>
<aside class="search-panel">
    <div class="input-group">
        <input type="text" class="text" placeholder="поиск">
        <button class="close"><?= Icon::close(); ?></button>
    </div>
    <ul class="result"></ul>

</aside>
