<div class="column feedback flex-4">

    <div class="button show-feedback">Задать вопрос</div>

    <div class="feedback-form">

        <h4 class="feedback-title">Напишите свой вопрос</h4>

        <div class="success-checkmark">
            <div class="check-icon none">
                <span class="icon-line line-tip"></span>
                <span class="icon-line line-long"></span>
                <div class="icon-circle"></div>
                <div class="icon-fix"></div>
            </div>
        </div>

        <form class="form" method="POST" action="/feedback/message">

            <div class="input-container">
                <input type="text" placeholder=" " required="" name="name" id="name" autocomplete="false">
                <div class="badge"></div>
                <label for="name">ваше имя</label>
                <div id="nameError"></div>
            </div>

            <div class="input-container">
                <input type="text" placeholder=" " required="" name="email" id="email" autocomplete="false">
                <div class="badge"></div>
                <label for="email">эл. почта</label>
                <div id="emailError"></div>
            </div>

            <div class="input-container">
                <input type="text" placeholder=" " required="" name="phone" id="phone" autocomplete="false">
                <div class="badge"></div>
                <label for="phone">телефон</label>
                <div id="phoneError"></div>
            </div>

            <div class="input-container textarea">
                <textarea name="message" placeholder=" " required="" id="message" rows="6" class="textarea"></textarea>
                <div class="badge"></div>
                <label for="message">Сообщение</label>
                <div id="messageError"></div>
            </div>

            <button type="submit" class="button button-filled feedback-submit" id="feedback-submit">Отправить
            </button>
        </form>

    </div>
</div>

