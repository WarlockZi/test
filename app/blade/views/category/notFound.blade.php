@extends('layouts.main.main')

@section('content')

    @php
        if (DEV) {
            if (isset($errors) && is_array($errors)) {
                foreach ($errors as $error) {
                    echo $error . '<br>';
                };
            }
        }
    @endphp


    <div class="category-not-found">

        <h1 class="not-found_h1">Категория не существует!</h1>


        <div class="actions">

            <div class="action">
                <a href="https://vitexopt.ru">перейти на главную страницу сайта</a>
            </div>


            <div class="action">похожие категории</div>
        </div>

        <div class="not-found">
            @if (!empty($similarCategories) && count($similarCategories))
                <div class="similar-categories">
                    @foreach ($similarCategories as $groupName=>$group)
                        @if(count($group))
                            <div>Группа {!!$groupName !!}</div>
                            <div class="similar-category">

                                @foreach($group as $child)
                                    @include('category.category_card', compact('child'))
                                @endforeach
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{--    <div class="not-found">--}}

    {{--        <div class="not-found_header">--}}

    {{--            <h1 class="not-found_h1">Данная страница не существует!</h1>--}}
    {{--            <div class="not-found_actions">--}}
    {{--                Вы можете <a href="https://vitexopt.ru">перейти на главную страницу сайта</a>--}}
    {{--            </div>--}}
    {{--        </div>--}}


    {{--        <div class="not-found_wrap">--}}
    {{--            <div class="not-found_container">--}}
    {{--                <h2 class="not-found_heading">Обратившись к нам, вы гарантировано получите--}}
    {{--                    не только<strong> лучшую цену, но и 100% качественную продукцию в сжатые сроки</strong>--}}
    {{--                </h2>--}}
    {{--                <a href="/offer" class="not-found_button" role="button">--}}
    {{--                    <span class="not-found_button_text">Получить выгодное предложение</span>--}}
    {{--                </a>--}}
    {{--            </div>--}}
    {{--        </div>--}}



    {{--    </div>--}}

@endsection
