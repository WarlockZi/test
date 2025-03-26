<?php

use app\Services\AdminSidebar\AdminSidebar;
use app\Services\AuthService\Auth;

?>

<div class="sidebar">
    <div class="wrap">

        <ul class="accordion">
            <?= AdminSidebar::build(Auth::getUser()); ?>
        </ul>

        <div class="admin_sidebar-tail"></div>
    </div>
</div>