@extends('layouts.main.main')

@section('title', 'Dynamic Page Title')
@section('description', 'This is a dynamic description.')
@section('keywords', 'Laravel, SEO, Dynamic Meta')


@section('content')
    <?php use app\view\components\shippable\ShippableUnitsTableFactory;
    use app\view\components\Icon\Icon;

    $authed = \app\service\AuthService\Auth::getUser();
    ?>
    <div class="cart">

        <h1>Корзина</h1>

        <?php if (empty($order) || !$order?->products?->count()): ?>

        <div class="empty-cart">
            Корзина пуста
        </div>

        <?php else: ?>

        <div class="content">

            <div class="table" data-order-id="<?= $order->id; ?>">

                    <?php foreach ($order?->products as $i => $product): ?>

                <div class="row cart-item" data-product-id="<?= $product['1s_id']; ?>">
                    <div class="num cell"><?= ++$i; ?></div>

                    <img src="<?= $product->mainImagePath; ?>" alt="<?= $product->name; ?>">

                    <div class="name-price cell">
                        <a href="/product/<?= $product->slug; ?>"
                           class="name">
                                <?= $product->name; ?>
                        </a>
                    </div>

                    <div class="cart-shippable-table cell">

                            <?= ShippableUnitsTableFactory::create($product, 'cart'); ?>
                    </div>

                    <div class="sub-sum sum cell"></div>
                    <div class="del cell"><?= Icon::trashWhite(); ?></div>
                </div>

                <?php endforeach; ?>


                <div class="total">
                    <div class="title">Всего -&nbsp;&nbsp;</div>
                    <span></span>
                </div>

                <div class="buttons">
                        <?php if (!\app\service\AuthService\Auth::getUser()): ?>
                    <div class="button" id="cartLogin"
                         title="Чтобы оформить заказ Вам &#10;необходимо зарегистрироваться &#10;или войти под своей учеткой">
                        Войти
                    </div>
                    <?php else: ?>
                    <div class="button" id="cartSubmit">Оформить заказ</div>
                    <?php endif; ?>
                </div>

            </div>

        </div>

    </div>
    <?php endif; ?>

@endsection
