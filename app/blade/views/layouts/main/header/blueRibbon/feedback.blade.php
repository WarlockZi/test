<?php

use app\view\components\Icon\Icon;

?>
<? if (\app\service\AuthService\Auth::getUser()->isAdmin()): ?>

    <a href="/adminsc/feedback" class="feedback" title="сообщения клиентов">
        <?= Icon::bell() ?>
        <div class="count"><?= $feedbackCount; ?></div>
    </a>
<? endif; ?>
