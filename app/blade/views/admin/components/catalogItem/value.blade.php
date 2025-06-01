<div class="value">

    <div
        <?= $field->id ?? ''; ?>
        <?= $field->getDatafield(); ?>
        <?= $field->getDatarelation(); ?>
        <?= $field->contenteditable; ?>
        <?= $field->required; ?>
    >
        @if(isset($field->dnd))
            @include('admin.components.dnd.dnd', ['dnd'=>$field->dnd])
        @else
                <?= $field->value; ?>
        @endif
    </div>

</div>