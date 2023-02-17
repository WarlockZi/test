<?

use app\model\User;

?>

<div class="user-credits">
	<div class="user-menu">
		<img src="<?= User::avatar($this->user); ?>" alt="">

		<div class="credits">
			<div class="fio"><?= "{$this->user['surName']} {$this->user['name']}"; ?></div>
			<div class="email"><?= $this->user['email']; ?></div>
		</div>
	</div>
</div>

