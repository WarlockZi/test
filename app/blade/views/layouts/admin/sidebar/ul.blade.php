<li>
    <div class="label">
        {!! $item['icon'] !!}
        {!! $item['name'] !!}
        <span class="arrow"></span>
    </div>

    <ul class="level-1">
        @foreach ($item['children'] as $child)
            @if ($item['permissions'])
                @if ($user->can($item['permissions']))
                    @include('layouts.admin.sidebar.child', ['item'=>$child])
                @endif
            @else
                @include('layouts.admin.sidebar.child', ['item'=>$child])
            @endif
        @endforeach
    </ul>
</li>