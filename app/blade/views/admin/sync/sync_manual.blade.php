@extends('layouts.admin.admin')

@section('content')
    @php
        use app\view\components\Icon\Icon;

        $showDnd = (!empty($loadFiles['offer']) && !empty($loadFiles['import']))?'slide-out':'';

        $showImport = !empty($loadFiles['import'])?'slide-in':'';
        $showOffer = !empty($loadFiles['offer'])?'slide-in':'';
        $showNoFiles = (!empty($loadFiles['import']) || !empty($loadFiles['offer']))?'slide-out':'';

        $buttonDisabled = empty($loadFiles['import'])||empty($loadFiles['offer'])?'disabled':'';

    @endphp

{{--            @deb--}}
    <div class="sync-manual" data-jsmodule="syncmanual">


        <div class="files-list">

            <div class="files-dnds {!!$showDnd!!}">
                <fieldset id="importDnd">
                    <legend>Перетащить файлы (можно сразу оба)</legend>
                    <div dndfile class='add-file'>{!!Icon::plus()!!}</div>
                </fieldset>
            </div>

            <div id='no-files' class="no-files {{$showNoFiles}}">нет файлов</div>

            <p id='offer' class="file {{$showOffer}}">offers0_1.xml</p>

            <p id='import' class="file {{$showImport}}">import0_1.xml</p>

            <div class="buttons-group">

                <button id="start-sync" class="button button-rounded {!!$buttonDisabled!!}">
                    <span class="btn__text">Загрузить обновление</span>
                    <span class="btn__spinner"></span>
                </button>

                <button id="delete-files" class="button button-rounded ">Удалить файлы</button>
            </div>
        </div>


        <div class="buttons">

            <div class="buttons-group">
                <button id="load-categories" class="button button-rounded">
                    <span class="btn__text">Загрузить категории</span>
                    <span class="btn__spinner"></span>
                </button>

                <button id="load-products" class="button button-rounded">
                    <span class="btn__text">Загрузить товары</span>
                    <span class="btn__spinner"></span>
                </button>
                <button id="load-prices" class="button button-rounded">
                    <span class="btn__text">Загрузить цены и остатки</span>
                    <span class="btn__spinner"></span>
                </button>
            </div>
        </div>

        <div class="loggs">

            <div class="buttons-group">
                <button id="clean-sync-success-log" class="button button-rounded">
                    <span class="btn__text">Очистить логи</span>
                    <span class="btn__spinner"></span>
                </button>
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
