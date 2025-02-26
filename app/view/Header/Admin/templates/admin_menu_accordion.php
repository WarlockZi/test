<?php

use app\core\Auth;
use app\core\Icon;
use app\Services\AdminSidebar\AdminSidebar;

?>

<div class="sidebar">
    <div class="wrap">

        <ul class="accordion">
            <?= AdminSidebar::build(Auth::getUser()); ?>
        </ul>

        <div class="admin_sidebar-tail"></div>
    </div>
</div>