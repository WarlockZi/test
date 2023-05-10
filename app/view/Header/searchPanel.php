<?php

use app\core\Icon;

?>
<div class="search-panel">
	<div class="wrap">
		<input type="text" class="text" placeholder="поиск">
		<div class="close"><?= Icon::close();?></div>
		<ul class="result"></ul>
	</div>
</div>
