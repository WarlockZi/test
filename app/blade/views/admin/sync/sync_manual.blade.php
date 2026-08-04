@extends('layouts.admin.admin')

@section('content')
{{--    @deb--}}
    @php
        use app\view\components\Icon\Icon;

        $showNoFiles = count($loadFiles)?'none':'';
        $showImportFile = !empty($loadFiles['import'])?'':'none';
        $showOfferFile = !empty($loadFiles['offer'])?'':'none';
        $buttonDisabled = count($loadFiles)===2?'':'disabled';

    @endphp

    <div class="sync-manual" data-jsmodule="syncmanual">

        <div class="sync-container files">
            @if(empty($loadFiles['import']))
                <fieldset>
                    <legend>Перетащить import file</legend>
                    <div dndfile class='add-file'
                         data-action="/adminsc/syncmanual/uploadimport"><?= Icon::plus() ?></div>
                </fieldset>
            @endif

            @if(empty($loadFiles['offer']))
                <fieldset>
                    <legend>Перетащить offer file</legend>
                    <div dndfile class='add-file'
                         data-action="/adminsc/syncmanual/uploadoffer"><?= Icon::plus() ?></div>
                </fieldset>
            @endif


            <br>
                <button class="button {!!$buttonDisabled!!}">Загрузить обновление</button>
            <br>
            <br>

        </div>

        <div class="files-list">
            <br>
            <br>
            <br>

            <div class="no-files {!!$showNoFiles!!}">нет файлов</div>

            <p id='offer' class="file {!!$showOfferFile!!}">offers0_1.xml</p>
            <p id='import' class="file {!!$showImportFile!!}">import0_1.xml</p>

        </div>

@endsection
