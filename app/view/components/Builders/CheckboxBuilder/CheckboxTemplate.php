<input
        my-checkbox
        type="checkbox"
    <?= $box['data'] ?? ''; ?>
    <?= $box['class'] ?? ''; ?>
    <?= $box['field'] ?? ''; ?>
    <?= $box['pivot'] ?? ''; ?>
    <?= $box['checked'] ? 'checked' : ''; ?>
>