<? $user = \app\controller\AuthController::user(); ?>
<div class="user-credits">
	<div class="user-menu">
		<img src="<?= \app\model\User::avatar($user); ?>" alt="">

		<div class="credits">
			<div class="fio"><?= "{$user['surName']} {$user['name']}"; ?></div>
			<div class="email"><?= $user['email']; ?></div>
		</div>
	</div>
</div>

