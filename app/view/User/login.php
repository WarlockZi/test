<main>
    <? echo isset($_SESSION['msg'])? $_SESSION['msg'] :''?>
    <form  method="post" class="form-container">
        <h1 class="form-title">Вход на сайт</h1>
        <input name="email" class="form-input" type="email" placeholder="E-mail"
               value="<?= isset($_SESSION['reg']['email']) ? $_SESSION['reg']['email'] : ''; ?>"/>
        <input name="password" class="form-input" type="password" placeholder="Пароль" autocomplete="current-password"/>
	    <div class="form-input submit" id="login" >Войти</div>
        <input type="hidden" name="token" value= <?= $_SESSION['token']?>>
        <ul class="bottom">
            <li>
                <a class="register" href="/user/register">Регистрация</a>
            </li>
            <li>
                <a class="forgot" href="/user/returnpass">Забыли пароль</a>
            </li>
        </ul>
    </form>
</main>
