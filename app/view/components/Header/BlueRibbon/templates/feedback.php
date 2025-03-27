<?php

use app\view\Icon;

?>
<? if (\app\Services\AuthService\Auth::getUser()->isAdmin()): ?>

    <a href="/adminsc/feedback" class="feedback" title="сообщения клиентов">
        <?= Icon::bell() ?>
        <div class="count"><?= $feedbackCount; ?></div>
    </a>
<? endif; ?>
