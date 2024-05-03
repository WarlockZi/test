<select name="dopUnit" id="">
    <?php foreach ($product->dopUnits as $dopUnit): ?>
        <option value="<?=$dopUnit->id?>"><?=$dopUnit->name?></option>
    <?php endforeach; ?>
</select>