<?php

use app\core\Icon;

?>
<div
		dnd
	<?= $dnd->path; ?>
	<?= $dnd->class; ?>
	<?= $dnd->tooltip; ?>
>
	<?= Icon::download() ?>
</div>


