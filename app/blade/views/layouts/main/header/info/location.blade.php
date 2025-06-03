@php
    use app\controller\Address;
    use app\view\components\Icon\Icon;
@endphp
<div
        class='location'
        itemprop="address"
        itemscope
        itemtype="https://schema.org/PostalAddress"
>

    <?= Icon::mapPin('feather'); ?>
    <?= Address::getFactAddress(); ?>

</div>
