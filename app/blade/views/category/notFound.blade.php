@extends('layouts.main.main_with_meta')


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


    <div class="category-not-found" data-jsmodule="category">

        <h1 class="not-found_h1">Категория не существует!</h1>


        <div class="actions">

            <div class="action">
                <a href="https://vitexopt.ru">перейти на главную страницу сайта</a>
            </div>

        </div>

        <h2 class="action">Похожие категории</h2>

        <div class="not-found">
            {{--            @deb--}}
            @if (!empty($similarCategories) && count($similarCategories))
                <div class="similar-categories">
                    @foreach ($similarCategories as $groupName=>$group)
                        @if(count($group))
                            <h3>Группа {!!$groupName !!}</h3>
                            <div class="similar-category">

                                {{--                                @deb--}}
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

@endsection
