<section>

	<form class="form-container" action="#" method="post">

		<div class="form-title">Регистрация на сайте</div>

		<div class='message'></div>

		<input type="email" name="email" class="form-input"
		       placeholder="E-mail"/>

		<input type="password" name="password" class="form-input"
		       placeholder="Пароль" current-password/>

		<input type="text" name="surName" class="form-input"
		       placeholder="Фамилия"/>

		<input type="text" name="name" class="form-input"
		       placeholder="Имя"/>

		<input type="hidden" name="token" value=<?= $_SESSION['token'] ?>>


		<div class="form__button reg">Зарегистрироваться</div>
		<div class="form__button-secondary forgot">Забыл пароль</div>
		<div class="form__button-secondary login">Войти</div>

		<p>Нажимая на кнопку "Регистрация", вы принимаете условия <a href="/about/oferta">Публичной оферты</a> и
			подтверждаете, что ознакомились с <a href="/about/oferta">Политикой</a> в отношении обработки персональных
			данных,
			принимаете ее условия и подтверждаете свое согласие на обработку персональных данных. </p>
	</form>


</section>
