<div class="total">
    <div class="title">Всего -&nbsp;&nbsp;</div>
    <span></span>
</div>

<div class="buttons">
    @if (!\app\service\AuthService\AuthService::getUser())
        <div class="button" id="cartLogin"
             title="Чтобы оформить заказ Вам &#10;необходимо зарегистрироваться &#10;или войти под своей учеткой">
            Войти
        </div>
    @else
        <div class="button" id="cartSubmit">Оформить заказ</div>
    @endif
</div>
