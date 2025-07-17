@php xdebug_break() @endphp
@if(!empty($checkbox['label']))
    <label
            <?= $checkbox['labelClass']; ?>
        <?= $checkbox['for']; ?>
    >
            <?= $checkbox['label']; ?>
    </label>

@endif


<input
        my-checkbox
        type="checkbox"
        {{--                @php xdebug_break() @endphp--}}
    <?= $checkbox["data"] ?? ''; ?>
    <?= $checkbox["class"] ?? ''; ?>
    <?= $checkbox["field"] ?? ''; ?>
    <?= $checkbox["pivot"] ?? ''; ?>
    <?= $checkbox["checked"] ? 'checked' : '' ?>
>