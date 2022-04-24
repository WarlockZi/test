<main>

  <?= $_SESSION['msg'] ?? ''; ?>
  <? unset($_SESSION['msg']) ?>

	<form class="auth" data-auth="returnpass">
		<div class='message'></div>
		<div class="title">Введите свой email</div>
		<input data-field="email"
					 type="email" name="email"
					 placeholder="E-mail"
					 value="<?= isset($_SESSION['reg']['email']) ? $_SESSION['reg']['email'] : ''; ?>"
					 required/>
		<div class="submit__button">Отправить</div>
		<div class="bottom">
			<a href="/auth/login">Войти</a>
			<a href="/auth/register"">Регистрация</a>
		</div>
	</form>
</main>