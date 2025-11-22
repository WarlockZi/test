@php
    use app\view\components\Builders\CheckboxBuilder\Checkbox\ICheckbox;
@endphp

@extends('layouts.admin.admin')

@section('content')

    <div custom-table
        <?= $data['class']; ?>
        <?= $data['dataModel'] ?>
        <?= $data['dataRelation'] ?>
        <?= $data['dataRelationType'] ?>
    >

        <div class='table-title'><?= $data['pageTitle'] ?></div>

        @deb
        @foreach($data['header'] as $title=>$html)
            <div class="table-header-row">
                    <?= $title ?> : <?= $html ?>
            </div>
        @endforeach

        <div class="custom-table"
            <?= $data['grid'] ?>
        >

            <!--  HEADER  -->
            @foreach ($data['columns'] as $c)
                <div
                        <?= $c->classHeader; ?>
                    <?= $c->type; ?>
                    <?= $c->sort; ?>
                >
                        <?= $c->sortIcon; ?>
                        <?= $c->name; ?>
                        <?= $c->search; ?>
                </div>
            @endforeach

            <!--  TABLE  -->

            <!--		 Empty row-->
            <?= $data['emptyRow'] ?>

                    <!--		 Data rows-->

            @if ($data['items']->count())

                @foreach ($data['items'] as $item)

                    @foreach ($data['columns'] as $field => $c)
                        @include('admin.components.table.row.tableRow', compact('field', 'c'))
                    @endforeach

                @endforeach

            @endif

        </div>
        @if (!$data['items']->count())

            <h3 class="no-items">Элементы не найдены</h3>
        @endif

        <!--  ADD BUTTON  -->
        @if($data['addButton'])

            <div class="buttons">
                <div class="add-model" {!!$data['pivot']??''!!}>+</div>
            </div>
        @endif

    </div>
@endsection