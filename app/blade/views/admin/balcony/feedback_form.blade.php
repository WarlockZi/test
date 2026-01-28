<div class="hystmodal modal-win js-modal-win" aria-hidden="false" id="modal-write-key-person">
    <div class="hystmodal__wrap modal-win__wrap">
        <div class="hystmodal__window modal-win__window" role="dialog" aria-modal="true">
            <div class="modal-win__container modal-write-key-person js-modal-write-key-person">
                <div class="modal-win__close" data-hystclose="">
                    <svg class="ico">
                        <use xlink:href="/public/src/balcony/images/interface.svg#close"></use>
                    </svg>
                </div>
                <div class="modal-win__content">
                    <section class="write-key-person-form js-write-key-person-form">
                        <div class="inner-container write-key-person-form__container">
                            <form class="write-key-person-form__form" name="writeKeyPerson"
                                  action="/ajax/?controller=form&action=add" novalidate="novalidate">
                                <input type="hidden" name="controller" value="form">
                                <input type="hidden" name="action" value="add">
                                <input type="hidden" name="owner" value="{{$data['email']}}">
                                <input type="hidden" name="bbc" value="">
                                <input type="hidden" name="form" value="owner">
                                <input type="hidden" name="attribute" value="mail">
                                <div class="h4 write-key-person-form__head-title">Написать</div>
                                <div class="write-key-person-form__content">
                                    <div class="write-key-person-form__group">
                                        <div class="control write-key-person-form__fio">
                                            <div class="control__group">
                                                <label class="control__label">Контактное лицо</label>
                                                <input class="control__input js-user-name" placeholder="Иван" id=""
                                                       name="user-name" type="text" required="" autocomplete="name">
                                            </div>
                                        </div>
                                        <div class="control write-key-person-form__phone">
                                            <div class="control__group">
                                                <label class="control__label">Контактный телефон</label>
                                                <input class="control__input js-user-phone" name="user-phone"
                                                       placeholder="+7(999)222-33-44" type="tel" required=""
                                                       autocomplete="tel">
                                            </div>
                                        </div>
                                        <div class="control write-key-person-form__email">
                                            <div class="control__group">
                                                <label class="control__label">Email</label>
                                                <input class="control__input js-user-email" id="" name="user-email"
                                                       placeholder="ivan@mail.ru" type="email" required=""
                                                       autocomplete="email">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="control write-key-person-form__comment">
                                        <div class="control__group">
                                            <label class="control__label">Комментарий</label>
                                            <textarea class="control__textarea js-user-message" id=""
                                                      name="user-message" cols="30" rows="10"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn write-key-person-form__btn" type="submit">Написать</button>
                                <div class="free-meas-form__person-data">
                                    <label class="checkbox-small checkbox-small--white"></label>

                                    <input class="checkbox-small__input js-person-data" type="checkbox"
                                           name="person-data" id="free-meas__person-data">
                                    <label class="checkbox-small__checkbox" for="free-meas__person-data"></label>
                                    <label class="checkbox-small__label" for="free-meas__person-data"><span
                                                class="checkbox-small__label">Нажимая на кнопку «Написать», я даю согласие на <a
                                                    href="/soglasiye.php" target="_blank" class="a no-style"><span>обработку своих персональных данных</span></a> и соглашаюсь с <a
                                                    href="/confidence.php" target="_blank" class="a no-style"><span>политикой конфиденциальности</span></a></span></label>
                                </div>
                            </form>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
