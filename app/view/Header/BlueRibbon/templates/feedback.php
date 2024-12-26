<?php

use app\core\Icon;

?>

<a href="/adminsc/feedback" class="feedback" title="сообщения клиентов">
    <?= Icon::bell() ?>
    <div class="count"><?=$feedbackCount;?></div>
</a>