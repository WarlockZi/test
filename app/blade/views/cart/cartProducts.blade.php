@php
    use app\service\AuthService\Auth;use app\view\components\Icon\Icon;

@endphp

@foreach ($order['products'] as $i => $product)

    <div class="row cart-item" data-product-id="{!!$product['1s_id']!!} ">
        <div class="num cell"><?= ++$i; ?></div>

        <img class="img" src="<?= $product['mainImage']; ?>" alt="<?= $product['name']; ?>">

        <div class="name-price cell">
            @if (Auth::getUser())
                <a href="/adminsc/product/edit/<?= $product['id']; ?>"
                   class="edit card-panel-item"
                >
                    {!!Icon::edit()!!}
                </a>
            @endif
            <a href="/product/<?= $product['slug']; ?>"
               class="name">
                    <?= $product['name']; ?>
            </a>
        </div>

        <div class="cart-shippable-table cell">
            @if(!$product)
                <div>продукт не определен</div>
            @else
                @include('cart.cartShippableUnits', compact('product'))
            @endif
        </div>

        @include('cart.cartSubSum')


        <div class="del cell"><?= Icon::trashWhite(); ?></div>
    </div>

@endforeach


<div class="total">
    <div class="title">Всего -&nbsp;&nbsp;</div>
    <span></span>
</div>

<div class="buttons">
    @if (!Auth::getUser())
        <div class="button" id="cartLogin"
             title="Чтобы оформить заказ Вам &#10;необходимо зарегистрироваться &#10;или войти под своей учеткой">
            Войти
        </div>
    @else
        <div class="button" id="cartSubmit">Оформить заказ</div>
    @endif
</div>
