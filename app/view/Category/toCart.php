<div class="to-cart">

    <div class="blue-button">Добавить</div>

    <div class="green-button">Перейти в корзину</div>
    <input type="number" maxlength="4" max="1000" min="0">
    <select id="selector">
        <? foreach ($product->shippableUnits as $shippableUnit): ?>
            <option value="<?= $shippableUnit->id ?>"><?= $shippableUnit->name ?></option>
        <? endforeach; ?>
    </select>

</div>
