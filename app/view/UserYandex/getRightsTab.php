<? ob_start(); ?>

	<div checkboxes
	     class='rights'
	     data-field='rights'
	>
		 <? foreach ($configRights as $right => $description): ?>
		  <div class="row">
			  <label class="name"
			         for="right<?= $right ?>"><?= $right; ?></label>
			  <input id="right<?= $right; ?>"
			         class="right"
			         data-id='<?= $right; ?>'
			         type="checkbox" <?= in_array($right, $user->rights) ? 'checked' : '' ?>>
			  <label class="description"
			         for="right<?= $right; ?>"
			  ><?= $description; ?></label>
		  </div>
		 <? endforeach; ?>

		 <? foreach ($rights as $right): ?>
		  <div class="row">
			  <label class="name"
			         for="right<?= $right['id'] ?>"><?= $right['name']; ?></label>
			  <input id="right<?= $right['id'] ?>"
			         class="right"
			         data-id='<?= $right['id'] ?>'
			         type="checkbox" <?= in_array($right['name'], $user->rights) ? 'checked' : '' ?>>
			  <label class="description"
			         for="right<?= $right['id'] ?>"
			  ><?= $right['description']; ?></label>
		  </div>
		 <? endforeach; ?>
	</div>


<? return ob_get_clean(); ?>