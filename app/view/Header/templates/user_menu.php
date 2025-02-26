<?php

use app\core\Auth;
use app\core\Icon;


$user = Auth::getUser(); ?>
<?php if (!$user): ?>

	<menu class="guest-menu" aria-label="login">
		 <?= Icon::user(); ?>
		<span>Вход</span>
	</menu>

<?php else: ?>

	<div class="user-menu">
		<img src="<?= $user->avatar() ?? ''; ?>" alt="">

		<div class="credits">
			<div class="fio"><?= $user->fi(); ?></div>
			<div class="email"><?= $user->mail(); ?></div>
		</div>

		<div class="menu">
			<a href="/auth/profile">Изменить свой профиль</a>
            <?php if ($user->isEmployee()||$user->isAdmin()): ?>
			  <a class="list__item" href="/adminsc">Admin</a>
            <?php endif; ?>

			<a href="/auth/logout" aria-label="logout" onclick="localStorage.setItem('id', null)">
					 <?= Icon::logout2(); ?>Выход</a>
		</div>
	</div>

<?php endif; ?>
