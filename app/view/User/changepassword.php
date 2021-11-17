<section>

    <?=$_SESSION['msg']??'';?>
    <?unset($_SESSION['msg'])?>
	
    <form class="form-container return_pass">
		<div class = "form-title">Сменить пароль</div>
	    <div class='message'></div>

	    <div class="pass">
		    <input type="password" name="old_password" class="form-input password" placeholder="старый пароль"
		           current-password required/>
		    <div class="password-control"></div>
	    </div>


	    <div class="pass">
		    <input type="password" name="new_password" class="form-input password" placeholder="новый пароль"
		           current-password required/>
		    <div class="password-control"></div>
	    </div>


		<input type="submit" class = "form__button form-input submit changepassword" value="Отправить" />
	</form>	
</section>