<details>
    <summary>
        @php
            $first_name = data_get($account,['users', 0 , 'name']) ?? data_get($account,['yandex_users', 0 , 'first_name']);
            $last_name = data_get($account,['users', 0 , 'surName']) ?? data_get($account,['yandex_users', 0 , 'last_name']);
            $email = data_get($account,['users', 0 , 'email']) ?? data_get($account,['yandex_users', 0 , 'default_email']);
        @endphp
        {!!$last_name!!}
        {!!$first_name!!}
        {!!$email!!}
        Акк id {!!$account['id']!!}</summary>

    @if(!empty($account['users']))
        <h2>Пользователи аккаунта</h2>
        {{--        @deb--}}
        <div class="users-grid">
            <div class="last-name header">Фамилия</div>
            <div class="name header">Имя</div>
            <div class="email header">email</div>
            @foreach($account['users'] as $user)
                <div class="last-name">{!!$user['surName']!!}</div>
                <div class="name">{!!$user['name']!!}</div>
                <div class="email">{!!$user['email']!!}</div>
            @endforeach
        </div>
    @endif
    @if(!empty($account['yandex_users']))
        <h2>yandex Пользователи аккаунта </h2>
        <div class="users-grid">
            <div class="last-name header">Фамилия</div>
            <div class="name header">Имя</div>
            <div class="email header">email</div>
            @foreach($account['yandex_users'] as $yandex_user)
                <div class="last-name">{!!$yandex_user['last_name']!!}</div>
                <div class="name">{!!$yandex_user['first_name']!!}</div>
                <div class="email">{!!$yandex_user['default_email']!!}</div>
            @endforeach
        </div>
    @endif

</details>


@if(!empty($account['orders']))

    @foreach($account['orders'] as $order)
        {{--        @deb--}}
        @php($orderitems = $order)
        @include('admin.order.orderProducts', compact('orderitems'))
    @endforeach
@endif

@if(!empty($account['cart_items']))
    <details>
        <summary>Неоформленный заказ</summary>
        @include('admin.order.cart')
    </details>
    <br>
    <br>
@endif


