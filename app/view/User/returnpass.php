<section>

    <?=$_SESSION['msg']??'';?>
    <?unset($_SESSION['msg'])?>
	
    <form class="form-container return_pass">
	    <div class='message'></div>
		<div class = "form-title">Введите свой email</div>
		<input class = "form-input" type="email" name="email"                
        placeholder="E-mail"  value="<?=isset($_SESSION['reg']['email'])?$_SESSION['reg']['email']:'';?>" required/>
	    <div class = "form__button returnpass" >Отправить</div>
	</form>	
</section>