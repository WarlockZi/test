<?php
if ($_ENV["DEV"] === "1") {
    if (isset($errors) && is_array($errors)) {

        foreach ($errors as $error) {
            echo $error . '<br>';
        };
    }
}

?>
<main class="not_found">

<div class="not_found_header">

    <h1 class="not_found_h1">Данная страница не существует!</h1>
    <div class="not_found_p">
        <p>Похоже, здесь ничего не найдено.</p>
        Вы можете <a href="https://vitexopt.ru">перейти на главную страницу сайта</a>
    </div>
</div>

    <div class="not_found_wrap">
        <div class="not_found_container">
            <h2 class="not_found_heading">Обратившись к нам, вы гарантировано получите
                не только<strong> лучшую цену, но и 100% качественную продукцию в сжатые сроки</strong>
            </h2>
        <a href="/offer" class="not_found_button" role="button">
            <span class="not_found_button_text">Получить выгодное предложение</span>
        </a>
        </div>
    </div>



</main>
