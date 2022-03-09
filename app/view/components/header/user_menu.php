<? if (!isset($this->user)): ?>

    <div class="guest-menu" aria-label="login">
        <? include ROOT . '/public/src/components/icons/user.svg'; ?>
        Вход
        <? if (!isset($this->user)): ?>
            <ul class="guest-menu__menu">
                <a href="/auth/login">Войти</a>
                <a href="/auth/register">Регистрация</a>
                <a href="/auth/returnpass">Забыл пароль</a>
            </ul>
        <? endif; ?>
    </div>


<? else: ?>

    <div class="user-menu">
        <img src="
        <?=$this->user['sex']==='f'
	        ?'/pic/ava_female.jpg'
	        :'/pic/ava_male.png';?>
        " alt="">
        <div class="user-menu__fio"><?= "{$this->user['surName']} {$this->user['name']}"; ?></div>
<!--        <hr>-->
        <div class="user-menu__menu">
            <a href="/auth/profile">Изменить свой профиль</a>
	        <?=in_array('gate_admin', $this->user['rights'])?
            "<a href='/adminsc'>Admin</a>"
	        :""
	        ;?>

            <a href="/auth/logout" aria-label="logout">
				<span class="icon-logout">
					<? include ICONS."/auth/logout2.php" ?>
				</span>
                Выход
            </a>
        </div>
    </div>
<? endif; ?>
