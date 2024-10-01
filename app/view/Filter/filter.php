<div class="filter">
    <div class="title"><?= $title ?? '' ?></div>

    <? if (is_array($options)): ?>
        <select <?= $name ?? '' ?>>
            <?= $emptyOption ?? '' ?>
            <? foreach ($options as $key => $value): ?>
                <? $selected = (array_key_exists($filterName, $userFilters) && $key == $userFilters[$filterName]['id']) ? 'selected' : ''; ?>
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
