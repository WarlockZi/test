@php
    use app\view\components\Builders\CheckboxBuilder\Checkbox\ICheckbox;
@endphp

<div custom-table
    <?= $data['class']; ?>
    <?= $data['dataModel'] ?>
    <?= $data['dataRelation'] ?>
    <?= $data['dataRelationType'] ?>
>

    <div class='table-title'><?= $data['pageTitle'] ?></div>

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
{{--        @php(xdebug_break())--}}
        @if (count($data['items']))
            @foreach ($data['items'] as $item)

                @foreach ($data['columns'] as $field => $c)

                    @if ($c->html)
                            <?= $c->html ?>
                    @else
                        <div
                                data-id='<?= $item['id'] ?? 0; ?>'
                                <?= $c->dataField; ?>
                            <?= $c->pivot; ?>
                            <?= $c->attach; ?>
                            <?= $c->class; ?>
                            <?= $c->contenteditable; ?>
                        >
                            {{--                            @php xdebug_break() @endphp--}}
                            @if($c->component instanceof ICheckbox)
                                @include('admin.components.checkbox.checkbox', ['checkbox'=>$c->component, 'item'=>$item] )
                            @else
                                {!!  $c->getData($c, $item, $field) !!}
                            @endif
                        </div>
                    @endif
                @endforeach
            @endforeach
        @endif

    </div>
{{--    @php(xdebug_break())--}}

    @if (!$data['items']->count())

        <h3 class="no-items">Элементы не найдены</h3>
    @endif

    <!--  ADD BUTTON  -->
{{--        @php xdebug_break() @endphp--}}
    @if($data['addButton'])
        <div class="buttons">
            <div class="add-model" {!! $data['pivot'] !!}>+</div>
        </div>
    @endif

</div>
