<? if (!isset($user)): ?>

    <div class="user-menu" aria-label="login">
        <?= include ROOT . '/app/view/components/icons/userIcon.php'; ?>
        Вход
        <? if (!isset($user)): ?>
            <ul class="guest-menu">
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
        <hr>
        <div class="nav">
            <a href="/user/edit">Изменить свой профиль</a>
            <a href="/user/cabinet">Личный кабинет</a>

            <? if (in_array('1', $user['rights']) || SU): ?>

            <? endif; ?>

            <? if (in_array('2', $user['rights'])): ?>
                <a href="/test/1">Проходить тесты</a>
                <!--			<a href="/freetest/41">Свободный тест</a>-->
            <? endif; ?>

            <?= in_array('3', $user['rights']) || SU ?
                '<a href="/adminsc">Admin</a>' : ''; // Admin
            ?>


            <a href="/user/logout" aria-label="logout">
				<span class="icon-logout">
					<?= require ROOT . "/app/view/components/icons/logout2.php" ?>
				</span>
                Выход
            </a>
        </div>
    </div>
<? endif; ?>
