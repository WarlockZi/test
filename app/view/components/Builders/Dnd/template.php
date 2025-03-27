<?php

use app\view\Icon;

?>
<div
        dnd
    <?= $dnd->path; ?>
    <?= $dnd->class; ?>
    <?= $dnd->tooltip; ?>
>
    <?= Icon::download() ?>
</div>


