@extends('layouts.admin.admin')

@section('content')
{{--    @deb--}}
    @php
        use app\view\components\Icon\Icon;

        $showNoFiles = count($loadFiles)?'none':'';
        $showImportFile = key_exists('import',$loadFiles)?'':'none';
        $showOfferFile = key_exists('offer',$loadFiles)?'':'none';
        $buttonDisabled = count($loadFiles)===2?'':'disabled';

    @endphp

    <div class="sync-manual" data-jsmodule="syncmanual">

        <div class="sync-container files">

            @if(!array_key_exists('import', $loadFiles))
                <fieldset>
                    <legend>Перетащить import file</legend>
                    <div dndfile class='add-file'
                         data-action="/adminsc/syncmanual/uploadimport"><?= Icon::plus() ?></div>
                </fieldset>
            @endif

            @if(!array_key_exists('offer', $loadFiles))
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
