<section>

    <?=$_SESSION['msg']??'';?>
    <?unset($_SESSION['msg'])?>
	
    <form class="form-container return_pass">
		<div class = "form-title">Введите свой email</div>
		<input class = "form-input" type="email" name="email"                
        placeholder="E-mail"  value="<?=isset($_SESSION['reg']['email'])?$_SESSION['reg']['email']:'';?>" required/>
		<input type="submit" class = "form-input submit" value="Отправить" />
	</form>	
</section>