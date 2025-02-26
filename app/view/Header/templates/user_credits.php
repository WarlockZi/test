<div class="user-credits">
	<div class="user-menu">
		<img src="<?= $user->avatar(); ?>" alt="">

		<div class="credits">
			<div class="fio"><?= "$user->surName $user->name"; ?></div>
			<div class="email"><?= $user->email; ?></div>
		</div>
	</div>
</div>

