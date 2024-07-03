


<?php $checkboxChecked = (!empty($userFilters) && key_exists($filterName, $userFilters)) ? "checked" : ""; ?>

<div class="filter-save">
    <label class="label" for="<?= $checkboxName ?>-filter">сохранять</label>
    <input type="checkbox" <?= $checkboxChecked ?? ''; ?> name="<?= $checkboxName ?>-filter" id="<?= $checkboxName ?>-filter">
</div>
