<main>


    <div class="auth" data-auth="login">
        <h1 class="title">Вход на сайт</h1>
        <div class='message'></div>

        <input type="email" name="email" autocomplete="on"/>

        <div class="pass">
            <input name="password" class="form-input password" type="password" placeholder="Пароль"
                   autocomplete="current-password"/>
            <div class="password-control"></div>
        </div>
        <div class="submit__button">Войти</div>

        <div class="bottom">
            <a href="/auth/register">Регистрация</a>
            <a href="/auth/returnpass">Забыли пароль</a>
            <!--            <a href="--><?php //= $url ?><!--" class="yandex" title="Авторизация Яндекс">-->
            <?= \app\Services\Icon::yandex() ?>
            </a>

        </div>
    </div>
</main>
