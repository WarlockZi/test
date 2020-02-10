<style>
  p {
      font-size: 10px;
  }
</style>
<section>
   
            <form class="form-container"  action="#" method="post">
			
				<div class="form-title">Регистрация на сайте</div>

                <input type="email"	   name="email"    class="form-input"                
                       placeholder="E-mail"/>
                
                <input type="password"  name="password" class="form-input"            
                       placeholder="Пароль"/>
                
                <input type='password'  name='confPass' class="form-input"
                       placeholder="Подтвердите пароль"/>
                
                <input type="text"      name="surName"    class="form-input"             
                       placeholder="Фамилия" />
                
                <input type="text"      name="name"   class="form-input"              
                       placeholder="Имя"/>

                <input type="text"      name="secName"   class="form-input"              
                       placeholder="Отчесво"/>
				<input type = "hidden" name="token" value=<?=$token?>>				

                <input type="submit"    name="reg"          class="form-input submit"     value="Зарегистрироваться" />
            </form>

  <p>Нажимая на кнопку "Регистрация", вы принимаете условия  <a href="/about/oferta">Публичной оферты</a> и подтверждаете, что ознакомились с   <a href="/about/oferta">Политикой</a> в отношении обработки персональных данных, принимаете ее условия и подтверждаете свое согласие на обработку персональных данных. Персональные данные, которые вы предоставили, будут использоваться исключительно для исполнения договора купли-продажи товара.</p>


  
</section>