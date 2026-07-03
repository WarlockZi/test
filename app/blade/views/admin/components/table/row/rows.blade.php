@if (count($data['items']))
    @foreach ($data['items'] as $item)

        @foreach ($data['columns'] as $field => $c)

            @include('admin.components.table.row.tableRow', compact('field', 'c','item'))

        @endforeach
    @endforeach
@endif