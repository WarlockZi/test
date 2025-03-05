<h1 class="page-name">Каталог</h1>
<div class="category">

    <?php

    if (isset($categories) && $categories): ?>

        <div class="category-child-wrap">
            <?php foreach ($categories as $category): ?>
                <?php if ($category): ?>

                    <div class="category-card">
                        <a class="category-card-a" href="/catalog/<?= $category->slug; ?>">
                            <?= $category->name ?>
                        </a>
                        <?= \app\view\share\card_panel\CardPanel::categoryCardPanel($category) ?>
                    </div>

                <?php endif; ?>

            <?php endforeach; ?>
        </div>

    <?php else: ?>
        <div class="no-categories">
            <H1>Категорий нет</H1>
        </div>
    <?php endif; ?>

</div>