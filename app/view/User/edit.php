<section>

	<form class="form-container" action="/user/edit" method="post">
		<div class="form-title">Редактирование данных</div>

		<div class='message'></div>

		<input class="form-input" placeholder="Имя" name="name" value="<?= $user['name'] ?>"/>

		<input class="form-input" placeholder="Фамилия" name="surName" value="<?= $user['surName'] ?>"/>

		<input class="form-input" placeholder="Отчество" name="middleName" value="<?= $user['middleName'] ?>"/>

		<input class="form-input" placeholder="День рождения:" name="birthDate" type="date"
		       value="<?= $user['birthDate'] ?>"/>

		<input class="form-input" placeholder="Телефон" name="phone" value="<?= $user['phone'] ?>"/>



		<div class="form__button" id = 'save'>Сохранить</div>

		<a href="/user/changepassword" class="form__button-secondary">Изменить пароль</a>
	</form>

</section>