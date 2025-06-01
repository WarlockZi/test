@php
//    xdebug_break();
         $checkboxChecked =
            (key_exists($filter->filterName, $filter->toSave) && $filter->toSave!=="0")
                ? "checked"
                : "";
@endphp

<div class="filter-save">
    <label class="label" for="<?= $filter->filterName ?>-filter">сохранять</label>
    <input type="checkbox" <?= $checkboxChecked ?? ''; ?>
    name="<?= $filter->filterName ?>"
           id="<?= $filter->filterName ?>-filter">
</div>
