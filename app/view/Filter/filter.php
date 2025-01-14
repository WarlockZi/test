<div class="filter">
    <div class="title"><?= $title ?? '' ?></div>

    <? if (is_array($options)): ?>
        <select <?= $name ?? '' ?> select-new>
            <?= $emptyOption ?? '' ?>
            <? foreach ($options as $key => $value): ?>
                <? $selected =
                    ($key === (int)$toFilter[$filterName]
                        && !empty($toFilter[$filterName]))
                        ? 'selected'
                        : ''; ?>
                <option value="<?= $key ?>" <?= $selected ?>><?= $value; ?></option>
            <? endforeach; ?>

        </select>

    <? elseif (is_string($options)): ?>
        <?= $options; ?>
    <? endif; ?>


    <? include 'checkboxSave.php' ?>

</div>
