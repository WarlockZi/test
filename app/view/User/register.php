<section>

	<form class="form-container" action="#" method="post">

	<div class="form-title">Регистрация на сайте</div>

		<div class='error'>
			<?  echo isset($_SESSION['email_exists']) ? "<p>Почта уже существует</p>": "";
				unset($_SESSION['email_exists']);
			?>
		</div>

		<input type="email" name="email" class="form-input"
		       placeholder="E-mail"/>

		<input type="password" name="password" class="form-input"
		       placeholder="Пароль"/>

		<input type="text" name="surName" class="form-input"
		       placeholder="Фамилия"/>

		<input type="text" name="name" class="form-input"
		       placeholder="Имя"/>

		<input type="hidden" name="token" value=<?= $_SESSION['token'] ?>>

		<input type="submit" name="reg" class="form-input submit" value="Зарегистрироваться"/>

	</form>

	<p>Нажимая на кнопку "Регистрация", вы принимаете условия <a href="/about/oferta">Публичной оферты</a> и
		подтверждаете, что ознакомились с <a href="/about/oferta">Политикой</a> в отношении обработки персональных данных,
		принимаете ее условия и подтверждаете свое согласие на обработку персональных данных. Персональные данные, которые
		вы предоставили, будут использоваться исключительно для исполнения договора купли-продажи товара.</p>

</section>
