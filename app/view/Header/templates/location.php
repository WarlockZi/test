<div
        class='location'
        itemprop="address"
        itemscope
        itemtype="https://schema.org/PostalAddress"
>

    <?= \app\core\Icon::mapPin('feather'); ?>
    <?= \app\controller\Address::getFactAddress(); ?>

</div>
