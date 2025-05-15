<div class="value">
{{--    @php xdebug_break() @endphp--}}
    <div
        <?= $field->id ?? ''; ?>
        <?= $field->getDatafield(); ?>
        <?= $field->getDatarelation(); ?>
        <?= $field->contenteditable; ?>
        <?= $field->required; ?>
    ><?= $field->value; ?></div>

</div>