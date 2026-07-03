@php
    use app\view\components\Icon\Icon;
@endphp

<div class='dnd-container'>
    <div
            dnd
            {!! $field->dnd->path!!}
            {!! $field->dnd->class!!}
            {!! $field->dnd->tooltip!!}
    >
        {!! Icon::download()!!}
    </div>
    @include('admin.components.image.image', ['img'=>$field->dnd->img])
</div>


