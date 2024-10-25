<main>


    <div class="auth" data-auth="login">
        <h1 class="title">Вход на сайт</h1>
        <div class='message'></div>
        <? $f = 1; ?>

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

            <?
            $url = 'https://vitexopt.ru';
            $params = array(
                'client_id' => '1cacd478c22b49c1a22e59ac811d0fc0',
                'redirect_uri' => $url,
                'response_type' => 'token',
                'state' => '123'
            );

            $url = 'https://oauth.yandex.ru/authorize?' . urldecode(http_build_query($params));
            ?>

            <hr>
            <hr>
            <a href="<?= $url ?>">Авторизация Яндекс</a>
        </div>
    </div>
</main>
