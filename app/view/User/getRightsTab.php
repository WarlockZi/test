<? ob_start(); ?>

	<div class='content user-rights'>
		 <? foreach ($rights as $right): ?>
		  <div class="row">
			  <label class="name"
			         for="right<?= $right['id'] ?>"><?= $right['name']; ?></label>
			  <input id="right<?= $right['id'] ?>"
			         class="right"
			         data-id='<?= $right['id'] ?>'
			         type="checkbox" <?= in_array($right['name'], $user['rights']) ? 'checked' : '' ?>>
			  <label class="description"
			         for="right<?= $right['id'] ?>"
			  ><?= $right['description']; ?></label>
		  </div>
		 <? endforeach; ?>
	</div>


<? return ob_get_clean(); ?>