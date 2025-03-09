<div multi-select
<?= $this->className ? "class='{$this->className}'" : ""; ?>"
data-field="<?= $this->field; ?>"
<?= $this->title ? "title='{$this->title}'" : ''; ?>
tabindex="0"

>
<div class="wrap">
    <div class="chip-wrap">
        <? foreach ($this->tree as $k => $v): ?>
            <? if (in_array($v['id'], $this->selected)): ?>
                <div class="chip" data-id="<?= $v['id']; ?>"><?= $v[$this->optionLabel] ?>
                    <div class="del">Х</div>
                </div>
            <? endif; ?>

        <? endforeach; ?>
    </div>

    <div class="arrow">
        <?= \app\core\Icon::ArrowDropDownIcon() ?>
    </div>

    <ul>
        <li class="inner">
            <? foreach ($this->tree as $k => $v): ?>
                <label for="<?= $v[$this->optionLabel] ?>"
                       data-id="<?= $v['id']; ?>"
                    <?= in_array($v['id'], $this->selected)
                        ? "class='selected'" : ''; ?>
                ><?= $v[$this->optionLabel] ?></label>
            <? endforeach; ?>
        </li>
    </ul>

    <select multiple="true">

        <? foreach ($this->tree as $k => $v): ?>
            <option
                    value="<?= $v['id'] ?>"
                <?= in_array($v['id'], $this->selected) ? 'selected' : ''; ?>
            ><?= $v[$this->optionName] ?>
            </option>
            <? $level = 0; ?>
            <? if (isset($v['childs'])): ?>
                <?= $this->getChilds($v['childs'], $level); ?>
            <? endif ?>

        <? endforeach; ?>


    </select>

</div>
</div>
