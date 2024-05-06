<div class="cart">

    <div class="<?= $oItems->count() ? '' : 'none'; ?> content">

        <div class="page-title">Корзина</div>

        <?php if (!$authed && !$lead): ?>
            <div id="counter">
                <p>Отлично! </p>
                <p>Чтобы мы смогли обработать ваш заказ - оставьте свои данные!</p>
                <p>Иначе корзина сгорит через</p>

                <div id="timer">
                    <div class="items">
                        <div class="item days">00</div>
                        <div class="item hours">00</div>
                        <div class="item minutes">00</div>
                        <div class="item seconds">00</div>
                    </div>
                </div>

            </div>
        <?php endif; ?>

        <div data-model="<?= $authed ? 'order' : 'orderItem'; ?>">

            <?php foreach ($oItems as $i => $oItem): ?>

                <? $product = $oItem->product; ?>
                <div class="row" data-product-id="<?= $product->id; ?>">
                    <div class="num"><?= ++$i; ?></div>

                    <img src="<?= $product->mainImagePath ?>" alt="<?= $product->name; ?>">

                    <div class="name-price">
                        <a href="/product/<?= $product->slug; ?>"
                           class="name">
                            <?= $product->name; ?>
                        </a>

                        <div class="price-table"
                             data-price=<?= $product->price ?>
                        >
                            <?php if ($product->baseUnit): ?>
                                <div class="price">
                                    <?= $product->formattedPrice ?>
                                </div>
                                <div class="unit">/ <?= $product->baseUnit->name; ?></div>
                            <?php endif; ?>

                            <?php if ($product->dopUnits->count()): ?>
                                <?php foreach ($product->dopUnits as $unit): ?>
                                    <div class="price">
                                        <?php
                                        $multiplier = $unit->pivot->multiplier;
                                        echo number_format($product->price * $multiplier, 2, '.', ' ');
                                        ?>
                                        ₽
                                    </div>
                                    <div class="unit">/ <?= $unit->name; ?></div>

                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php include __DIR__ . '/countSetter.php' ?>

                    <div class="sum"></div>
                    <div class="del"><?= $trashedWhite; ?></div>
                </div>

                <!--        </div>-->

            <?php endforeach; ?>


            <div class="total">
                <div class="title">Всего -&nbsp;&nbsp;</div>
                <span></span>&nbsp;&nbsp;₽
            </div>

            <?php if (!$authed && !$lead): ?>
                <div class="buttons">
                    <div class="button" id="cartLead">Оставить свои данные</div>
                    <div class="button" id="cartLogin">Войти под своей учеткой</div>
                </div>
            <?php else: ?>
                <div class="buttons">
                    <div class="button" id="cartSuccess">Оформить заказ</div>
                </div>
            <?php endif; ?>

        </div>

        <div class="empty-cart <?= $oItems->count() ? 'none' : ''; ?>">
            Корзина пуста
        </div>
    </div>




