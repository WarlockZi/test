@php
    use app\service\AuthService\Auth;
    $user = Auth::getUser()
@endphp
<div class="sidebar">
    <div class="wrap">

        <ul class="accordion">
            @foreach ($layout->sidebar->sidebar as $item)

                @if ($item['children'])

                    @if ($item['permissions'] && $user->can($item['permissions']))
                        @include('layouts.admin.sidebar.ul', compact('item', 'user'))
                    @else
                        @include('layouts.admin.sidebar.ul', compact('item', 'user'))
                    @endif

                @else

                    @if ($item['permissions'] && $user->can($item['permissions']))
                        @include('layouts.admin.sidebar.a', compact('item', 'user'))
                    @else
                        @include('layouts.admin.sidebar.a', compact('item', 'user'))
                    @endif

                @endif

            @endforeach

        </ul>

        <div class="admin_sidebar-tail"></div>
    </div>
</div>