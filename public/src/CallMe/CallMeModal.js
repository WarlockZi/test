import FieldBuilder from "../components/Modal/builders/FieldBuilder.js";

import {createElement, emailValidator, passwordValidator,getPhpSession, post, sanitizeInput} from "../common.js";
import {qs} from "@src/constants.js";

export default class CallMeModal {
   constructor() {
      return {
         1: [this.getCallMeRows()],
      }
   }

   getCallMeRows() {
      return [
         "Перезвоним в течение 5 минут",
         this.getPhoneInput(),
         this.getCallMeButton(),
         this.getLoginWarning(),
      ]
   }

   getPhoneInput() {
      return (new FieldBuilder)
         .id('phone')
         .required()
         .name('phone')
         .type('text')
         .errorEl('#emailError')
         .badgeWidth('65px')
         .placeholder('телефон')
         .get()
   }

   getCallMeButton() {
      const registerButton = this.createButton("Заказать звонок")
      registerButton.addEventListener('click', this.callme.bind(this))
      return registerButton
   }

   getLoginWarning() {
      return (new createElement()).tag('p').text("Оставляя свои данные, вы соглашаетесь с политикой конфиденциальности").get()
   }


   createButton(text) {
      return (new createElement()).tag('button').attr('type', 'submit').attr('class', 'button').attr('id', 'forgot').text(text).get()
   }


   async callme(e) {
      YM('click_on_callme')
      const res = await post('/callme', this.authDTO(e));
      const content = e.target.closest('.content')
      if (res?.arr?.success) {
         content.innerHTML =
            '<p>-Ждите звонка на указанный номер.</p>'
      } else {
         content.innerHTML = res?.arr?.error??'Неизвестная ошибка';
      }
   }


   authDTO(e) {
      e.preventDefault()
      const form = e.target.closest('.box')
      return {
         phone:sanitizeInput(form[qs]('input#phone')?.value) ?? null,
         php_session:getPhpSession() ?? null}
   }

}