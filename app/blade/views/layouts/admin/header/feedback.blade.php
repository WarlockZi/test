<?php

use app\repository\FeedbackRepository;
use \app\service\AuthService\Auth;
use app\view\components\Icon\Icon;

?>
<? if (Auth::getUser()->isAdmin()): ?>

    <a href="/adminsc/feedback" class="feedback" title="сообщения клиентов">
        <?= Icon::bell() ?>
        <div class="count"><?= FeedbackRepository::getCount(); ?></div>
    </a>
<? endif; ?>
