<?php
if (DEV) {
    if (isset($errors) && is_array($errors)) {

        foreach ($errors as $error) {
            echo $error . '<br>';
        };
    }
}

?>
<div class="not-found">

    <div class="not-found_header">

        <h1 class="not-found_h1">Данная страница не существует!</h1>
        <div class="not-found_actions">
            Вы можете <a href="https://vitexopt.ru">перейти на главную страницу сайта</a>
        </div>
    </div>


    <div class="not-found_wrap">
        <div class="not-found_container">
            <h2 class="not-found_heading">Обратившись к нам, вы гарантировано получите
                не только<strong> лучшую цену, но и 100% качественную продукцию в сжатые сроки</strong>
            </h2>
            <a href="/offer" class="not-found_button" role="button">
                <span class="not-found_button_text">Получить выгодное предложение</span>
            </a>
        </div>
    </div>

</div>

<? if (!empty($similarProducts) && $similarProducts->count()): ?>

    <div class="similar-products">
        <h2 class="similar-products__header">Похожие товары</h2>
        <div class="product-wrap">
            <? foreach ($similarProducts as $product): ?>
                <?php include ROOT . '/app/view/Category/product_card.php' ?>
            <? endforeach ?>
        </div>

    </div>
<? endif; ?>

