<main>

	<div class="auth" data-auth="login">
		<h1 class="title">Вход на сайт</h1>
		<div class='message'></div>

		<? if (isset($_SESSION['msg'])): ?>
			<div class="login_return_pass"><?= $_SESSION['msg'];
				unset($_SESSION['msg']) ?></div>
		<? endif; ?>

		<input type="email" placeholder="E-mail"
		       value="<?= $_SESSION['reg']['email'] ?? ''; ?>"/>

		<div class="pass">
			<input name="password" class="form-input password" type="password" placeholder="Пароль"
			       autocomplete="current-password"/>
			<div class="password-control"></div>
		</div>
		<div class="submit__button" >Войти</div>

		<div class="bottom">
				<a href="/auth/register">Регистрация</a>
				<a href="/auth/returnpass">Забыли пароль</a>
		</div>
	</div>
</main>
