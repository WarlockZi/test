<div class="filter">
    <div class="title"><?= $title ?? '' ?></div>

    <? if (is_array($options)): ?>
        <select <?= $name ?? '' ?> select-new>
            <?= $emptyOption ?? '' ?>
            <? foreach ($options as $key => $value): ?>
                <? $selected =
                    ($key===(int)$userFilters[$filterName]
                    && isset($userFilters[$filterName]))
                    ? 'selected'
                    : ''; ?>
                <option value="<?= $key ?>" <?= $selected ?>><?= $value; ?></option>
            <? endforeach; ?>

        </select>

    <? elseif (is_string($options)): ?>
        <?= $options; ?>
    <? endif; ?>

    <? if ($checkboxSave): ?>
        <? include 'checkboxSave.php' ?>
    <? endif; ?>

</div>
