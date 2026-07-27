@extends('layouts.admin.admin')

@section('content')
{{--    @deb--}}
    @php
        use app\view\components\Icon\Icon;

        $showNoFiles = count($xmlFiles)?'none':'';
        $showImportFile = key_exists('import',$xmlFiles)?'':'none';
        $showOfferFile = key_exists('offer',$xmlFiles)?'':'none';
        $buttonDisabled = count($xmlFiles)===2?'':'disabled';

    @endphp

    <div class="sync">

        <div class="files-list">
            <br>
            <br>
            <br>

            <div class="no-files {!!$showNoFiles!!}">нет файлов</div>


            <p id='offer' class="file {!!$showOfferFile!!}">offers0_1.xml</p>
            <p id='import' class="file {!!$showImportFile!!}">import0_1.xml</p>


        </div>

        <div class="container files">
            @if(!array_key_exists('import', $xmlFiles))
                <fieldset>
                    <legend>Перетащить import file</legend>
                    <div dndfile class='add-file'
                         data-action="/adminsc/syncmanual/uploadimport"><?= Icon::plus() ?></div>
                </fieldset>
            @endif

            @if(!array_key_exists('offer', $xmlFiles))
                <fieldset>
                    <legend>Перетащить offer file</legend>
                    <div dndfile class='add-file'
                         data-action="/adminsc/syncmanual/uploadoffer"><?= Icon::plus() ?></div>
                </fieldset>
            @endif


            <br>
            <a href='/adminsc/syncmanual/load' class="button {!!$buttonDisabled!!}">Загрузить обновления</a>
            <br>
            <br>


            <div id="log_content"></div>
        </div>

@endsection
