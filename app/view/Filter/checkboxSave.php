<?php $checkboxChecked =
    (key_exists($filterName, $toSave) && $toSave!=="0")
        ? "checked"
        : ""; ?>

<div class="filter-save">
    <label class="label" for="<?= $filterName ?>-filter">сохранять</label>
    <input type="checkbox" <?= $checkboxChecked ?? ''; ?>
           name="<?= $filterName ?>-filter"
           id="<?= $filterName ?>-filter">
</div>
