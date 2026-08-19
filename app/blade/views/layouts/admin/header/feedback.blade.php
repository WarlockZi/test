<?php

use app\repository\FeedbackRepository;
use \app\service\AuthService\AuthService;
use app\view\components\Icon\Icon;

?>
<? if (AuthService::getUser()->isAdmin()): ?>

<a href="/adminsc/feedback" class="feedback" title="сообщения клиентов">
        <?= Icon::bell() ?>
    <div class="count"><?= FeedbackRepository::getCount(); ?></div>
</a>
<? endif; ?>
