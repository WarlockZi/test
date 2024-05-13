<div class="to-cart">

    <div class="button blue-button">Добавить</div>

    <div class="green-button-wrap">
        <a href="/cart" class="button green-button">Перейти в корзину</a>
        <div class="count-wrap">
            <input type="number" maxlength="4" max="1000" min="0" class="input">
            <select id="selector" class="selector">
                <?php foreach ($product->shippableUnits as $shippableUnit): ?>
                    <option value="<?= $shippableUnit->id ?>"><?= $shippableUnit->name ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

</div>
