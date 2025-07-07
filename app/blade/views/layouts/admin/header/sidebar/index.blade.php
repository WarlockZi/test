@php
    use app\service\AdminSidebar\AdminSidebar;
    use app\service\AuthService\Auth;
    $user = Auth::getUser();
    $adminSidebar = (new AdminSidebar)();
@endphp
<div class="sidebar">
    <div class="wrap">

        <ul class="accordion">

            @foreach ($adminSidebar as $item)

                @if ($item['children'])

                    @if ($item['permissions'] && $user->can($item['permissions']))
                        @include('layouts.admin.header.sidebar.ul', compact('item', 'user'))
                    @else
                        @include('layouts.admin.header.sidebar.ul', compact('item', 'user'))
                    @endif

                @else

                    @if ($item['permissions'] && $user->can($item['permissions']))
                        @include('layouts.admin.header.sidebar.a', compact('item', 'user'))
                    @else
                        @include('layouts.admin.header.sidebar.a', compact('item', 'user'))
                    @endif

                @endif

            @endforeach

        </ul>

        <div class="admin_sidebar-tail"></div>
    </div>
</div>