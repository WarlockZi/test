<select id="shippableSelector">
    <?php foreach ($product->shippableUnits as $shippable): ?>
        <option value="<?=$shippable->id?>"><?=$shippable->name?></option>
    <?php endforeach; ?>
</select>