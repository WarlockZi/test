<section class="free-meas-form js-free-meas-form">
    <div class="inner-container free-meas-form__container">
        <div class="free-meas-form__block cta_override">
            <div class="free-meas-form__bg">
                <img class="img lazyload"
                     src="{{$data['images']}}cta/1.webp">
            </div>

            <div class="free-meas-form__row">
                <form class="free-meas-form__form" action="/ajax/?controller=form&action=add">
                    <input type="hidden" name="form" value="zamer">
                    <input type="hidden" name="attribute" value="ct">
                    <div class="free-meas-form__content">
                        <div class="free-meas-form__title-block">
                            <div class="h2 free-meas-form__title">Запишитесь на бесплатный замер</div>
                            <!-- <div class="free-meas-form__subtitle"><sup>*</sup> Оконных и дверных конструкций</div> -->
                        </div>
                        <div class="free-meas-form__group">
                            <div class="control free-meas-form__fio">
                                <div class="control__group">
                                    <label class="control__label">Ваше имя</label>
                                    <input class="control__input js-user-name" placeholder="Иван" name="name"
                                           type="text" autocomplete="name">
                                </div>
                            </div>
                            <div class="control free-meas-form__phone">
                                <div class="control__group">
                                    <label class="control__label">Номер телефона</label>
                                    <input class="control__input js-user-phone" placeholder="+7(111)222-33-44"
                                           name="phone" type="tel" autocomplete="tel">
                                </div>
                            </div>
                            <button class="btn btn--red free-meas-form__btn">Записаться</button>
                            <div class="free-meas-form__person-data">
                                <label class="checkbox-small checkbox-small--white">
                                    <input class="checkbox-small__input js-person-data" type="checkbox"
                                           name="person-data" id="free-meas__person-data">
                                    <label class="checkbox-small__checkbox"
                                           for="free-meas__person-data"></label>
                                    <span class="checkbox-small__label">Нажимая на кнопку «Записаться», я даю согласие на <a
                                                href="/soglasiye.php" target="_blank" class="a no-style"><span>обработку своих персональных данных</span></a> и соглашаюсь с <a
                                                href="/confidence.php" target="_blank" class="a no-style"><span>политикой конфиденциальности</span></a></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

