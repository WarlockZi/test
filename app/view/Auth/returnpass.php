<main>

  <?= $_SESSION['msg'] ?? ''; ?>
  <? unset($_SESSION['msg']) ?>

	<form class="auth" data-auth="returnpass">
		<div class="title">Введите свой email</div>
		<div class='message'></div>
		<input data-field="email"
					 type="email" name="email"
					 placeholder="E-mail"
					 value="<?= isset($_SESSION['reg']['email']) ? $_SESSION['reg']['email'] : ''; ?>"
					 required/>
		<div class="submit__button">Отправить</div>
		<div class="bottom">
			<a href="/auth/login" rel="nofollow">Войти</a>
			<a href="/auth/register" rel="nofollow"">Регистрация</a>
		</div>
	</form>
</main>