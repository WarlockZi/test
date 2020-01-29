<main>

    <? if (isset($_SESSION['msg'])) echo $_SESSION['msg'] ?>
    <form action='/user/login' method="post" class="form-container">
        <h1 class="form-title">Вход на сайт</h1>
        <input name="email" class="form-input" type="email" placeholder="E-mail"
               value="<?= isset($_SESSION['reg']['email']) ? $_SESSION['reg']['email'] : ''; ?>"/>
        <input name="pass" class="form-input" type="password" placeholder="Пароль"/>
        <input class="form-input submit" type="submit" id="login" value="Войти"/>
        <input type="hidden" name="token" value= <?= isset($_SESSION['token']) ?$_SESSION['token']: ngei123555 ?>>
        <ul class="bottom">
            <li>
                <a class="register" href="<?= PROJ ?>/user/register">Регистрация</a>
            </li>
            <li>
                <a class="forgot" href="<?= PROJ ?>/user/returnpass">Забыли пароль</a>
            </li>
        </ul>
    </form>


</main>
<style>

    /*************************
    *******     Forms  ******
    **************************/

    .form-container {
        display: flex;
        flex-flow: column wrap;
        padding: 35px 30px 15px 30px;
        background: #eee;
        width: 300px;
        margin: 3% auto;
        align-items: stretch;
    }

    .form-title {
        font-weight: bold;
        font-size: 120%;
        text-align: center;
        color: #949494;
        margin-bottom: 20px;
    }

    .form-input {
        background: #f7f7f7;
        border-radius: 0;
        border-bottom: 1px solid #ccc;
        border-left: 0;
        border-top: 0;
        border-right: 0;
        flex: 1;
        margin: 10px 0;
        padding: 12px;
        width: 100%;
        box-sizing: border-box;
        color: #757575;
    }

    .submit {
        padding: 14px;
        background: rgba(0, 0, 0, 0.15);
        text-align: center;
        font-weight: 600;

    }

    .submit:hover {
        background: #adadad;
        color: #fff;
    }


    .bottom {
        display: flex;
        align-items: center;
    }

    .bottom li {
        flex: 1;
        text-align: center;
        display: flex;
    }

    .bottom li a {
        color: #949494;
        flex-basis: 100%;
        padding: 10px 3px;
    }

    .bottom li a:hover {
        color: #fff;
        background-color: #ccc;
    }


</style>
<script src="/public/build/login.js"></script>