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
