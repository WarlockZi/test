<?php

use app\core\Icon;

?>
<a class="cart" href="/cart">
	<div class="count<?= $oItems ? ' show' : ''; ?>"><?= $oItems; ?></div>
	<?= Icon::shoppingCart('feather'); ?>
</a>