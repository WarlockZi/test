<?
use \app\model\User;

?>
<div class="admin-layout_header">
	<a href='/' class="logo" aria-label='На главную'>
		 <? include ROOT . '/app/view/Header/admin/logo_VITEX_grey.php' ?>
	</a>

	<? if (User::can($this->user)): ?>
		<? include ROOT . '/app/view/Header/admin/chips.php' ?>
	<? endif; ?>

	<!--	<a title="Whatsapp" href="whatsapp://send?phone=79814362309"><img src="/pic/WhatsApp.jpg" alt="Написать в Whatsapp" /></a>-->
	<? include ROOT . '/app/view/Header/user_menu.php' ?>
</div>
