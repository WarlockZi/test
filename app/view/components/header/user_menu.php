<? if (!isset($user)): ?>

    <div class="guest-menu" aria-label="login">
        <? include ROOT . '/public/src/components/icons/user.svg'; ?>
        Вход
        <? if (!isset($user)): ?>
            <ul class="guest-menu__menu">
                <a href="/user/login">Войти</a>
                <a href="/user/register">Регистрация</a>
                <a href="/user/returnpass">Забыл пароль</a>
            </ul>
        <? endif; ?>
    </div>


<? else: ?>

    <div class="user-menu">
        <img src="/public/src/Admin/components/userPhoto.png" alt="">
        <div class="user-menu__fio"><?= "{$user['surName']} {$user['name']}"; ?></div>
<!--        <hr>-->
        <div class="user-menu__menu">
            <a href="/user/edit">Изменить свой профиль</a>
            <a href="/user/cabinet">Личный кабинет</a>

            <? if (in_array('1', $user['rights']) || SU): ?>

            <? endif; ?>


            <?= in_array('3', $user['rights']) || SU ?
                '<a href="/adminsc">Admin</a>' : ''; // Admin
            ?>


            <a href="/user/logout" aria-label="logout">
				<span class="icon-logout">
					<?= include ROOT . "/app/view/components/icons/auth/logout2.php" ?>
				</span>
                Выход
            </a>
        </div>
    </div>
<? endif; ?>
