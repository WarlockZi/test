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


    <div class="category-not-found">

        <h1 class="not-found_h1">Продукт не существует!</h1>


        <div class="actions">

            <div class="action">
                <a href="https://vitexopt.ru">перейти на главную страницу сайта</a>
            </div>


            <div class="action">похожие продукты</div>
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

@endsection
