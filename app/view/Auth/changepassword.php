<main>

	<form class="auth return_pass">
		<div class="title">Сменить пароль</div>
		<div class='message'></div>

		<label>старый пароль</label>
		<div class="pass">
			<input type="password" name="old_password" class="form-input password"
			       current-password required/>
			<div class="password-control"></div>
		</div>


		<label>новый пароль</label>
		<div class="pass">
			<input type="password" name="new_password" class="form-input password"
			       current-password required/>
			<div class="password-control"></div>
		</div>


		<input type="button" class="submit__button changepassword" value="Отправить"/>
	</form>

</main>