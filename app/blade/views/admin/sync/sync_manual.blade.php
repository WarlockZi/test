@extends('layouts.admin.admin')

@section('content')
    @php
        use app\view\components\Icon\Icon;

    @endphp

    <div class="sync">

        <div class="container files">

            <fieldset>
                <legend>load zip archive</legend>
                <div dnd data-action="/adminsc/syncmanual/uploadZip"><?= Icon::plus() ?></div>
            </fieldset>

            <div class="button" id="logshow">Загрузить обновления</div>
            <br>


            <div id="log_content"></div>
        </div>



@endsection
