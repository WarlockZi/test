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
        @elseif(!empty($field->checkbox))
            @include('admin.components.checkbox.checkbox', ['checkbox'=>$field->checkbox])
        @else
                <?= $field->value; ?>
        @endif
    </div>

</div>