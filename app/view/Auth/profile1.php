<section>

	<form class="form-container" action="/user/edit" method="post">
		<div class="form-title">Редактировать профиль</div>

		<div class='message'></div>

		<div>emial</div>
		<div class='email form-input'><?= $this->user['email'] ?></div>

		<div>Имя</div>
		<input class="form-input" placeholder="Имя" name="name" value="<?= $this->user['name'] ?>"/>

		<div>Фамилия</div>
		<input class="form-input" placeholder="Фамилия" name="surName" value="<?= $this->user['surName'] ?>"/>

		<div>Отчество</div>
		<input class="form-input" placeholder="Отчество" name="middleName" value="<?= $this->user['middleName'] ?>"/>

		<div>День рождения</div>
		<input class="form-input" placeholder="День рождения:" name="birthDate" type="date"
		       value="<?= $this->user['birthDate'] ?>"/>

		<div>Номер телефона</div>
		<input class="form-input" placeholder="Телефон" name="phone" value="<?= $this->user['phone'] ?>"/>

		<div>Пол</div>
		<div class="radio-wrap">
			<label for="male">Муж
			<input <?= $this->user['sex'] === 'm' ? 'checked' : ''; ?>
					type=radio id='male' class="form-input sex" placeholder="Пол" name="sex" value="m"/>
			</label>
			<label for="female">Жен
			<input <?= $this->user['sex'] === 'f' ? 'checked' : ''; ?>
					type=radio id='female' class="form-input sex" placeholder="Пол" name="sex" value="f"/>
			</label>
		</div>


		<div class="form__button" id='save'>Сохранить</div>

		<a href="/auth/changepassword" class="form__button-secondary">Изменить пароль</a>
	</form>

</section>