<section>

    <?=$_SESSION['msg']?>
    <?unset($_SESSION['msg'])?>
	
    <form class="form-container" method='POST'>
		<div class = "form-title">Введите свой почтовый адрес</div>
		<input class = "form-input" type="email" name="email"                
        placeholder="E-mail"  value="<?=isset($_SESSION['reg']['email'])?$_SESSION['reg']['email']:'';?>" required/>
		<input type="submit" name="submit" class = "form-input" value="Отправить" />
	</form>	
</section>