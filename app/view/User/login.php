<main>
    <? if (isset($_SESSION['msg'])) echo $_SESSION['msg'] ?>
    <form action='#' method="post" class="form-container">
        <h1 class="form-title">Вход на сайт</h1>
        <input name="email" class="form-input" type="email" placeholder="E-mail"
               value="<?= isset($_SESSION['reg']['email']) ? $_SESSION['reg']['email'] : ''; ?>"/>
        <input name="pass" class="form-input" type="password" placeholder="Пароль" autocomplete="current-password"/>
        <input class="form-input submit" type="submit" id="login" value="Войти"/>
        <input type="hidden" name="token" value= <?= isset($_SESSION['token']) ?$_SESSION['token']: ngei123555 ?>>
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
