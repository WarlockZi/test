<div
        class='location'
        itemprop="address"
        itemscope
        itemtype="https://schema.org/PostalAddress"
>

    <?= \app\view\components\Icon\Icon::mapPin('feather'); ?>
    <?= \app\controller\Address::getFactAddress(); ?>

</div>
