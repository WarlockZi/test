@extends('layouts.admin.admin')

@section('content')
    @php
        use app\view\components\Icon\Icon;

    @endphp

    <div class="sync">

        <div class="container files">

            <fieldset>
                <legend>load zip archive</legend>
                <div dnd data-action="/adminsc/syncmanual/uploadextract"><?= Icon::plus() ?></div>
            </fieldset>

            <a href='/adminsc/syncmanual/load' class="button">Загрузить обновления</a>
            <br>


            <div id="log_content"></div>
        </div>



@endsection
