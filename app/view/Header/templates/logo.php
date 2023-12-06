<?

use app\core\Icon;
use app\core\Router;

$index = Router::getRoute()->isHome();
$logo = Icon::logo_squre1() . Icon::logo_vitex1();

if ($index): ?>
	<div class="logo">
		 <?= $logo; ?>
	</div>

<? else: ?>
	<a href='/' class="logo" aria-label='На главную'>
		 <?= $logo; ?>
	</a>
<? endif; ?>