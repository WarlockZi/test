<div class="modals-container">
    {{--    Заказать расчет--}}
    <div class="hystmodal window-decor-form modal-win js-modal-win" aria-hidden="true" id="modal-calc-win">
        <div class="hystmodal__wrap modal-win__wrap">
            <div class="hystmodal__window window-decor-form__window" role="dialog" aria-modal="true">
                <div class="window-decor-form__container js-modal-calc-win">

                    <div class="window-decor-form__close close-icon" data-hystclose="">
                        <span></span>
                        <span></span>
                    </div>

                    <div class="window-decor-form__block">

                        <div class="window-decor-form__bg">
                            <img class="img lazyload"
                                 src="{{$data['images']}}cta/1.webp" alt="">
                        </div>

                        <div class="window-decor-form__row">
                            <form class="window-decor-form__main modal-calc-win__form"
                                  action="/ajax/?controller=form&action=add">
                                <input type="hidden" name="controller" value="form">
                                <input type="hidden" name="action" value="add">
                                <input type="hidden" name="form" value="calc_window_popup">
                                <input type="hidden" name="attribute" value="ct">
                                <input class="js-user-name" type="hidden" name="name" value="">
                                <div class="modal-win__head-title">Заказать расчет</div>
                                <div class="control control--white modal-win__control">
                                    <div class="control__group">
                                        <label class="control__label">Номер телефона</label>
                                        <input class="control__input js-user-phone" name="phone"
                                               placeholder="+7(999)888-77-66" type="tel" required="" autocomplete="tel">
                                    </div>
                                </div>
                                <div class="modal-win__btn">
                                    <button class="btn btn--red js-btn-submit" type="submit">Рассчитать</button>
                                </div>
                                <div class="modal-win__person-data">
                                    <label class="checkbox-small checkbox-small--white">
                                        <input class="checkbox-small__input js-person-data" type="checkbox"
                                               name="person-data" id="modal-form__person-data">
                                        <label class="checkbox-small__checkbox" for="modal-form__person-data"></label>
                                        <span class="checkbox-small__label">Нажимая на кнопку «Рассчитать», я даю согласие на <a
                                                    href="/soglasiye.php" target="_blank" class="a no-style"><span>обработку своих персональных данных</span></a> и соглашаюсь с <a
                                                    href="/confidence.php" target="_blank" class="a no-style"><span>политикой конфиденциальности</span></a></span>
                                    </label>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--    Заказать расчет--}}
    <div class="hystmodal window-decor-form modal-win js-modal-win" aria-hidden="true" id="modal-calc-config">
        <div class="hystmodal__wrap modal-win__wrap">
            <div class="hystmodal__window window-decor-form__window" role="dialog" aria-modal="true">
                <div class="window-decor-form__container js-modal-calc-win">

                    <div class="window-decor-form__close close-icon" data-hystclose="">
                        <span></span>
                        <span></span>
                    </div>

                    <div class="window-decor-form__block">

                        <div class="window-decor-form__bg">
                            <img class="img lazyload"
                                 data-src="/new_style_files/upload/img_verstka/forms/red-square-opt-2.webp" alt="">
                        </div>

                        <div class="window-decor-form__row">

                            <form class="window-decor-form__main modal-calc-win__form"
                                  action="/ajax/?controller=form&action=add">
                                <input type="hidden" name="controller" value="form">
                                <input type="hidden" name="action" value="add">
                                <input type="hidden" name="form" value="configurator">
                                <input type="hidden" name="attribute" value="ct">
                                <input class="js-user-name" type="hidden" name="name" value="">
                                <div class="modal-win__head-title">Заказать расчет</div>
                                <div class="control control--white modal-win__control">
                                    <div class="control__group">
                                        <label class="control__label">Номер телефона</label>
                                        <input class="control__input js-user-phone" name="phone"
                                               placeholder="+7(999)888-77-66" type="tel" required="" autocomplete="tel">
                                    </div>
                                </div>
                                <div class="modal-win__btn">
                                    <button class="btn btn--red js-btn-submit" type="submit">Рассчитать</button>
                                </div>
                                <div class="modal-win__person-data">
                                    <label class="checkbox-small checkbox-small--white">
                                        <input class="checkbox-small__input js-person-data" type="checkbox"
                                               name="person-data" id="modal-form__person-data">
                                        <label class="checkbox-small__checkbox" for="modal-form__person-data"></label>
                                        <span class="checkbox-small__label">Нажимая на кнопку «Отправить», я даю согласие на <a
                                                    href="/soglasiye.php" target="_blank" class="a no-style"><span>обработку своих персональных данных</span></a> и соглашаюсь с <a
                                                    href="/confidence.php" target="_blank" class="a no-style"><span>политикой конфиденциальности</span></a></span>
                                    </label>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--    Заказать консультацию--}}
    <div class="hystmodal window-decor-form modal-win js-modal-win" aria-hidden="true" id="modal-consult">
        <div class="hystmodal__wrap modal-win__wrap">
            <div class="hystmodal__window window-decor-form__window" role="dialog" aria-modal="true">
                <div class="window-decor-form__container js-modal-calc-win">

                    <div class="window-decor-form__close close-icon" data-hystclose="">
                        <span></span>
                        <span></span>
                    </div>

                    <div class="window-decor-form__block">

                        <div class="window-decor-form__bg">
                            <img class="img lazyload"
                                 data-src="/new_style_files/upload/img_verstka/forms/red-square-opt-2.webp" alt="">
                        </div>

                        <div class="window-decor-form__row">
                            <form class="window-decor-form__main modal-calc-win__form"
                                  action="/ajax/?controller=form&action=add">
                                <input type="hidden" name="controller" value="form">
                                <input type="hidden" name="action" value="add">
                                <input type="hidden" name="form" value="consult">
                                <input type="hidden" name="attribute" value="ct">
                                <input class="js-user-name" type="hidden" name="name" value="">
                                <div class="modal-win__head-title">Заказать консультацию</div>
                                <div class="control control--white modal-win__control">
                                    <div class="control__group">
                                        <label class="control__label">Номер телефона</label>
                                        <input class="control__input js-user-phone" name="phone"
                                               placeholder="+7(999)888-77-66" type="tel" required="" autocomplete="tel">
                                    </div>
                                </div>
                                <div class="modal-win__btn">
                                    <button class="btn btn--red js-btn-submit" type="submit">Отправить</button>
                                </div>
                                <div class="modal-win__person-data">
                                    <label class="checkbox-small checkbox-small--white">
                                        <input class="checkbox-small__input js-person-data" type="checkbox"
                                               name="person-data" id="modal-form__person-data">
                                        <label class="checkbox-small__checkbox" for="modal-form__person-data"></label>
                                        <span class="checkbox-small__label">Нажимая на кнопку «Отправить», я даю согласие на <a
                                                    href="/soglasiye.php" target="_blank" class="a no-style"><span>обработку своих персональных данных</span></a> и соглашаюсь с <a
                                                    href="/confidence.php" target="_blank" class="a no-style"><span>политикой конфиденциальности</span></a></span>
                                    </label>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--    Записаться на замер--}}
    <div class="hystmodal window-decor-form modal-win js-modal-win" aria-hidden="true" id="modal-zamer">
        <div class="hystmodal__wrap modal-win__wrap">
            <div class="hystmodal__window window-decor-form__window" role="dialog" aria-modal="true">
                <div class="window-decor-form__container js-modal-calc-win">

                    <div class="window-decor-form__close close-icon" data-hystclose="">
                        <span></span>
                        <span></span>
                    </div>

                    <div class="window-decor-form__block">

                        <div class="window-decor-form__bg">
                            <img class="img lazyload"
                                 data-src="/new_style_files/upload/img_verstka/forms/red-square-opt-2.webp" alt="">
                        </div>

                        <div class="window-decor-form__row">

                            <form class="window-decor-form__main modal-calc-win__form"
                                  action="/ajax/?controller=form&action=add">
                                <input type="hidden" name="controller" value="form">
                                <input type="hidden" name="action" value="add">
                                <input type="hidden" name="form" value="zamer">
                                <input type="hidden" name="attribute" value="ct">
                                <input class="js-user-name" type="hidden" name="name" value="">
                                <div class="modal-win__head-title">Записаться на замер</div>
                                <div class="control control--white modal-win__control">
                                    <div class="control__group">
                                        <label class="control__label">Номер телефона</label>
                                        <input class="control__input js-user-phone" name="phone"
                                               placeholder="+7(999)888-77-66" type="tel" required="" autocomplete="tel">
                                    </div>
                                </div>
                                <div class="modal-win__btn">
                                    <button class="btn btn--red js-btn-submit" type="submit">Отправить</button>
                                </div>
                                <div class="modal-win__person-data">
                                    <label class="checkbox-small checkbox-small--white">
                                        <input class="checkbox-small__input js-person-data" type="checkbox"
                                               name="person-data" id="modal-form__person-data">
                                        <label class="checkbox-small__checkbox" for="modal-form__person-data"></label>
                                        <span class="checkbox-small__label">Нажимая на кнопку «Отправить», я даю согласие на <a
                                                    href="/soglasiye.php" target="_blank" class="a no-style"><span>обработку своих персональных данных</span></a> и соглашаюсь с <a
                                                    href="/confidence.php" target="_blank" class="a no-style"><span>политикой конфиденциальности</span></a></span>
                                    </label>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--    Зафиксировать цену--}}
    <div class="hystmodal window-decor-form modal-win js-modal-win" aria-hidden="true" id="modal-fixprice">
        <div class="hystmodal__wrap modal-win__wrap">
            <div class="hystmodal__window window-decor-form__window" role="dialog" aria-modal="true">
                <div class="window-decor-form__container js-modal-calc-win">

                    <div class="window-decor-form__close close-icon" data-hystclose="">
                        <span></span>
                        <span></span>
                    </div>

                    <div class="window-decor-form__block">

                        <div class="window-decor-form__bg">
                            <img class="img lazyload"
                                 data-src="/new_style_files/upload/img_verstka/forms/red-square-opt-2.webp" alt="">
                        </div>

                        <div class="window-decor-form__row">

                            <form class="window-decor-form__main modal-calc-win__form"
                                  action="/ajax/?controller=form&action=add">
                                <input type="hidden" name="controller" value="form">
                                <input type="hidden" name="action" value="add">
                                <input type="hidden" name="form" value="zamer">
                                <input type="hidden" name="attribute" value="ct">
                                <input class="js-user-name" type="hidden" name="name" value="">
                                <div class="modal-win__head-title">Зафиксировать цену</div>
                                <div class="control control--white modal-win__control">
                                    <div class="control__group">
                                        <label class="control__label">Номер телефона</label>
                                        <input class="control__input js-user-phone" name="phone"
                                               placeholder="+7(999)888-77-66" type="tel" required="" autocomplete="tel">
                                    </div>
                                </div>
                                <div class="modal-win__btn">
                                    <button class="btn btn--red js-btn-submit" type="submit">Отправить</button>
                                </div>
                                <div class="modal-win__person-data">
                                    <label class="checkbox-small checkbox-small--white">
                                        <input class="checkbox-small__input js-person-data" type="checkbox"
                                               name="person-data" id="modal-form__person-data">
                                        <label class="checkbox-small__checkbox" for="modal-form__person-data"></label>
                                        <span class="checkbox-small__label">Нажимая на кнопку «Отправить», я даю согласие на <a
                                                    href="/soglasiye.php" target="_blank" class="a no-style"><span>обработку своих персональных данных</span></a> и соглашаюсь с <a
                                                    href="/confidence.php" target="_blank" class="a no-style"><span>политикой конфиденциальности</span></a></span>
                                    </label>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--    Заказать звонок--}}
    <div class="hystmodal window-decor-form modal-win js-modal-win" aria-hidden="true" id="modal-calc-callback">
        <div class="hystmodal__wrap modal-win__wrap">
            <div class="hystmodal__window window-decor-form__window" role="dialog" aria-modal="true">
                <div class="window-decor-form__container js-modal-calc-win">

                    <div class="window-decor-form__close close-icon" data-hystclose="">
                        <span></span>
                        <span></span>
                    </div>

                    <div class="window-decor-form__block">

                        <div class="window-decor-form__bg">
                            <img class="img lazyload"
                                 data-src="/new_style_files/upload/img_verstka/forms/red-square-opt-2.webp" alt="">
                        </div>

                        <div class="window-decor-form__row">

                            <form class="window-decor-form__main modal-calc-win__form"
                                  action="/ajax/?controller=form&action=add">
                                <input type="hidden" name="controller" value="form">
                                <input type="hidden" name="action" value="add">
                                <input type="hidden" name="form" value="callback_popup">
                                <input type="hidden" name="attribute" value="ct">
                                <input class="js-user-name" type="hidden" name="name" value="">
                                <div class="modal-win__head-title">Заказать звонок</div>
                                <div class="control control--white modal-win__control">
                                    <div class="control__group">
                                        <label class="control__label">Номер телефона</label>
                                        <input class="control__input js-user-phone" name="phone"
                                               placeholder="+7(999)888-77-66" type="tel" required="" autocomplete="tel">
                                    </div>
                                </div>
                                <div class="modal-win__btn">
                                    <button class="btn btn--red js-btn-submit" type="submit">Отправить</button>
                                </div>
                                <div class="modal-win__person-data">
                                    <label class="checkbox-small checkbox-small--white">
                                        <input class="checkbox-small__input js-person-data" type="checkbox"
                                               name="person-data" id="modal-form__person-data">
                                        <label class="checkbox-small__checkbox" for="modal-form__person-data"></label>
                                        <span class="checkbox-small__label">Нажимая на кнопку «Отправить», я даю согласие на <a
                                                    href="/soglasiye.php" target="_blank" class="a no-style"><span>обработку своих персональных данных</span></a> и соглашаюсь с <a
                                                    href="/confidence.php" target="_blank" class="a no-style"><span>политикой конфиденциальности</span></a></span>
                                    </label>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--    Заказать--}}
    <div class="hystmodal window-decor-form modal-win js-modal-win" aria-hidden="true" id="modal-order-win">
        <div class="hystmodal__wrap modal-win__wrap">
            <div class="hystmodal__window window-decor-form__window" role="dialog" aria-modal="true">
                <div class="window-decor-form__container js-modal-calc-win">

                    <div class="window-decor-form__close close-icon" data-hystclose="">
                        <span></span>
                        <span></span>
                    </div>

                    <div class="window-decor-form__block">

                        <div class="window-decor-form__bg">
                            <img class="img lazyload"
                                 data-src="/new_style_files/upload/img_verstka/forms/red-square-opt-2.webp" alt="">
                        </div>

                        <div class="window-decor-form__row">

                            <form class="window-decor-form__main modal-calc-win__form"
                                  action="/ajax/?controller=form&action=add">
                                <input type="hidden" name="controller" value="form">
                                <input type="hidden" name="action" value="add">
                                <input type="hidden" name="form" value="order_window_popup">
                                <input type="hidden" name="attribute" value="ct">
                                <input class="js-user-name" type="hidden" name="name" value="">
                                <div class="modal-win__head-title">Заказать</div>
                                <div class="control control--white modal-win__control">
                                    <div class="control__group">
                                        <label class="control__label">Номер телефона</label>
                                        <input class="control__input js-user-phone" name="phone"
                                               placeholder="+7(999)888-77-66" type="tel" required="" autocomplete="tel">
                                    </div>
                                </div>
                                <div class="modal-win__btn">
                                    <button class="btn btn--red js-btn-submit" type="submit">Заказать</button>
                                </div>
                                <div class="modal-win__person-data">
                                    <label class="checkbox-small checkbox-small--white">
                                        <input class="checkbox-small__input js-person-data" type="checkbox"
                                               name="person-data" id="modal-form__person-data">
                                        <label class="checkbox-small__checkbox" for="modal-form__person-data"></label>
                                        <span class="checkbox-small__label">Нажимая на кнопку «Заказать», я даю согласие на <a
                                                    href="/soglasiye.php" target="_blank" class="a no-style"><span>обработку своих персональных данных</span></a> и соглашаюсь с <a
                                                    href="/confidence.php" target="_blank" class="a no-style"><span>политикой конфиденциальности</span></a></span>
                                    </label>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--    Заказать--}}
    <div class="hystmodal window-decor-form modal-win js-modal-win" aria-hidden="true" id="modal-mosqit-order">
        <div class="hystmodal__wrap modal-win__wrap">
            <div class="hystmodal__window window-decor-form__window" role="dialog" aria-modal="true">
                <div class="window-decor-form__container js-modal-calc-win">

                    <div class="window-decor-form__close close-icon" data-hystclose="">
                        <span></span>
                        <span></span>
                    </div>

                    <div class="window-decor-form__block">

                        <div class="window-decor-form__bg">
                            <img class="img lazyload"
                                 data-src="/new_style_files/upload/img_verstka/forms/red-square-opt-2.webp" alt="">
                        </div>

                        <div class="window-decor-form__row">

                            <form class="window-decor-form__main modal-mosqit-order"
                                  action="/ajax/?controller=form&action=add">
                                <input type="hidden" name="controller" value="form">
                                <input type="hidden" name="action" value="add">
                                <input type="hidden" name="form" value="order_window_popup">
                                <input type="hidden" name="attribute" value="ct">
                                <input type="hidden" name="order" value="">
                                <input type="hidden" name="price" value="">
                                <input class="js-user-name" type="hidden" name="name" value="">
                                <div class="modal-win__head-title">Заказать</div>
                                <div class="control control--white modal-win__control">
                                    <div class="control__group">
                                        <label class="control__label">Номер телефона</label>
                                        <input class="control__input js-user-phone" name="phone"
                                               placeholder="+7(999)888-77-66" type="tel" required="" autocomplete="tel">
                                    </div>
                                </div>
                                <div class="modal-win__btn">
                                    <button class="btn btn--red js-btn-submit" type="submit">Заказать</button>
                                </div>
                                <div class="modal-win__person-data">
                                    <label class="checkbox-small checkbox-small--white">
                                        <input class="checkbox-small__input js-person-data" type="checkbox"
                                               name="person-data" id="modal-form__person-data">
                                        <label class="checkbox-small__checkbox" for="modal-form__person-data"></label>
                                        <span class="checkbox-small__label">Нажимая на кнопку «Заказать», я даю согласие на <a
                                                    href="/soglasiye.php" target="_blank" class="a no-style"><span>обработку своих персональных данных</span></a> и соглашаюсь с <a
                                                    href="/confidence.php" target="_blank" class="a no-style"><span>политикой конфиденциальности</span></a></span>
                                    </label>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--    Наш менеджер скоро свяжется c Вами! success--}}
    <div class="hystmodal modal-win js-modal-win" aria-hidden="true" id="modal-success-form">
        <div class="hystmodal__wrap modal-win__wrap">
            <div class="hystmodal__window modal-win__window" role="dialog" aria-modal="true">
                <div class="modal-win__container modal-calc-win">
                    <div class="modal-win__close" data-hystclose="">
                        <svg class="ico">
                            <use xlink:href="/public/src/balcony/images/interface.svg#close"></use>
                        </svg>
                    </div>
                    <div class="modal-win__content">
                        <div class="modal-win__head-title">Спасибо!<br>Наш менеджер скоро свяжется c Вами!</div>
                        <div class="js-flocktory-banner" style="height: 0; opacity: 0;"></div>
                        <div class="modal-win__btn">
                            <div class="btn" data-hystclose="">Отлично</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--    Упс! Возникла ошибка. error--}}
    <div class="hystmodal modal-win js-modal-win" aria-hidden="true" id="modal-error">
        <div class="hystmodal__wrap modal-win__wrap">
            <div class="hystmodal__window modal-win__window" role="dialog" aria-modal="true">
                <div class="modal-win__container modal-error js-modal-error">
                    <div class="modal-win__close" data-hystclose="">
                        <svg class="ico">
                            <use xlink:href="/public/src/balcony/images/interface.svg#close"></use>
                        </svg>
                    </div>
                    <div class="modal-win__content">
                        <div class="modal-win__head-title">Упс! Возникла ошибка.</div>
                        <div class="modal-win__head-desc">Ничего страшного, мы уже разбираемся в причинах. Попробуйте
                            повторить позднее или обращайтесь по телефону
                            <nobr><a class="no-style" href="tel:74959887888">+7 (495) 988-78-88</a></nobr>
                            .
                        </div>
                        <div class="modal-win__btn">
                            <div class="btn" data-hystclose="">ОК</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>