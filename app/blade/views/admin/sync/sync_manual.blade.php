@extends('layouts.admin.admin')

@section('content')
    @php
        use app\view\components\Icon\Icon;

        $showImportFile = !empty($loadFiles['import'])?'':'none';
        $showOfferFile = !empty($loadFiles['offer'])?'':'none';

        $showImportDnd = empty($loadFiles['import'])?'':'none';
        $showOfferDnd = empty($loadFiles['offer'])?'':'none';

        $showNoFiles = empty($loadFiles['import']) && empty($loadFiles['offer'])?'':'none';

        $buttonDisabled = empty($loadFiles['import'])||empty($loadFiles['offer'])?'disabled':'';

    @endphp

    {{--    @deb--}}
    <div class="sync-manual" data-jsmodule="syncmanual">

        <div class="files-dnds">

            <fieldset id="importDnd" class="{!!$showImportDnd!!}">
                <legend>Перетащить import file</legend>
                <div dndfile class='add-file'
                     data-action="/adminsc/syncmanual/uploadimport"><?= Icon::plus() ?></div>
            </fieldset>


            <fieldset id="offerDnd" class="{!!$showOfferDnd!!}">
                <legend>Перетащить offer file</legend>
                <div dndfile class='add-file'
                     data-action="/adminsc/syncmanual/uploadoffer"><?= Icon::plus() ?></div>
            </fieldset>


        </div>

        <div class="files-list">

            <div class="no-files {!!$showNoFiles!!}">нет файлов</div>

            <p id='offer' class="file {!!$showOfferFile!!}">offers0_1.xml</p>
            <p id='import' class="file {!!$showImportFile!!}">import0_1.xml</p>
        </div>

        <div></div>
        <div class="buttons">

            <div class="buttons-group">
                <button id="start-sync" class="button button-rounded {!!$buttonDisabled!!}">Загрузить обновление
                </button>
                <button id="delete-files" class="button button-rounded ">Удалить файлы</button>
            </div>

            <div class="buttons-group">
                <button id="load-categories" class="button button-rounded ">Загрузить категории</button>
                <button id="load-products" class="button button-rounded ">Загрузить товары</button>
                <button id="load-prices" class="button button-rounded ">Загрузить цены и остатки</button>
            </div>
        </div>

        <div class="loggs">
            <div class="buttons-group">
                <button id="clean-sync-success-log" class="button button-rounded ">Очистить логи</button>
            </div>
            <div class="log-strings">
                @if($logLines)
                    @foreach($logLines as $text)
                        <div class="log-string">{!!$text!!}</div>
                    @endforeach
                @endif
            </div>

        </div>

@endsection
