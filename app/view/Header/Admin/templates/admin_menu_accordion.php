<?php

use app\core\Auth;
use app\core\Icon;
use app\Services\AdminSidebar\AdminSidebar;

?>

<div class="sidebar">
    <div class="wrap">

        <div class="header">
            <?= Icon::gamburger() ?>
            <?php include ROOT . '/app/view/Header/templates/user_credits.php' ?>
        </div>

        <ul class="accordion">
            <?= AdminSidebar::build(Auth::getUser()); ?>
        </ul>

        <div class="admin_sidebar-tail"></div>
    </div>
</div>