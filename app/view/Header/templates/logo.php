<?php

if ($index): ?>
	<div class="logo">
		 <?= $logo; ?>
	</div>

<?php else: ?>
	<a href='/' class="logo" aria-label='На главную'>
		 <?= $logo; ?>
	</a>
<?php endif; ?>