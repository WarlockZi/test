<?

use app\model\User;

?>

<div class="user-credits">
	<div class="user-menu">
		<img src="<?= User::avatar($user); ?>" alt="">

		<div class="credits">
			<div class="fio"><?= "{$user['surName']} {$user['name']}"; ?></div>
			<div class="email"><?= $user['email']; ?></div>
		</div>
	</div>
</div>

