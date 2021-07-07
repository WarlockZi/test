<section>

    <?=$_SESSION['msg']??'';?>
    <?unset($_SESSION['msg'])?>
	
    <form class="form-container return_pass">
		<div class = "form-title">Сменить пароль</div>
	    <div class='message'></div>
		<input class = "form-input" type="email" name="old_password"
		       placeholder="старый пароль"
             required/>

	    <input class = "form-input" type="email" name="new_password"
	           placeholder="новый пароль"
	           required/>
		<input type="submit" class = "form-input submit changepassword" value="Отправить" />
	</form>	
</section>