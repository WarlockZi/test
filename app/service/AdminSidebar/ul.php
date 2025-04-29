<li>
    <div class="label">
        <?= $item['icon'] ?>
        <?= $item['name'] ?>
        <span class="arrow"></span>
    </div>

    <ul class="level-1">
        <?php foreach ($item['children'] as $child): ?>
            <?= $this->child($child) ?>
        <?php endforeach ?>
    </ul>
</li>


