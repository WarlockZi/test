<?php

if ($data['index']): ?>
	<div class="logo">
		 <?= $data['logo']; ?>
	</div>

<?php else: ?>
	<a href='/' class="logo" aria-label='На главную'>
		 <?= $data['logo']; ?>
	</a>
<?php endif; ?>