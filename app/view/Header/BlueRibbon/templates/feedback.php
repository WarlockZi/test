<?php

use app\core\Icon;

?>
<? if (\app\core\Auth::getUser()->isAdmin()): ?>

    <a href="/adminsc/feedback" class="feedback" title="сообщения клиентов">
        <?= Icon::bell() ?>
        <div class="count"><?= $feedbackCount; ?></div>
    </a>
<? endif; ?>
