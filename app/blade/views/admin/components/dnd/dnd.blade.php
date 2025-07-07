@php
    use app\view\components\Icon\Icon;
@endphp

<div class='dnd-container'>
    <div
            dnd
            {!!  $dnd->path !!}
            {!!  $dnd->class !!}
            {!!  $dnd->tooltip !!}
    >
        {!!  Icon::download() !!}
    </div>
    @include('admin.components.image.image', ['img'=>$dnd->img])
</div>


