<?php

use app\service\AdminSidebar\AdminSidebar;
use app\service\AuthService\Auth;

?>

<div class="sidebar">
    <div class="wrap">

        <ul class="accordion">
            <?= AdminSidebar::build(Auth::getUser()); ?>
        </ul>

        <div class="admin_sidebar-tail"></div>
    </div>
</div>