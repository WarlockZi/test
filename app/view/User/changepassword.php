<section>

    <?=$_SESSION['msg']??'';?>
    <?unset($_SESSION['msg'])?>
	
    <form class="form-container return_pass">
		<div class = "form-title">Сменить пароль</div>
		<input class = "form-input" type="email" name="email"
		       placeholder="старый пароль"
             required/>

	    <input class = "form-input" type="email" name="email"
	           placeholder="новый пароль"
	           required/>
		<input type="submit" class = "form-input submit" value="Отправить" />
	</form>	
</section>