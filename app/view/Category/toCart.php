<div class="to-cart">

    <div class="blue-button">Добавить</div>

    <div class="green-button-wrap">
        <div class="green-button">Перейти в корзину</div>
        <div class="count-wrap">
            <input type="number" maxlength="4" max="1000" min="0">
            <select id="selector">
                <?php foreach ($product->shippableUnits as $shippableUnit): ?>
                    <option value="<?= $shippableUnit->id ?>"><?= $shippableUnit->name ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

</div>
