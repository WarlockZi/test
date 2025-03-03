import FieldBuilder from "../components/Modal/builders/FieldBuilder.js";

import {createElement, getPhpSession, post, sanitizeInput} from "../common.js";
import {qs} from "@src/constants.js";
import PhoneValidator from "@src/components/validator/PhoneValidator.js";

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
   showErrors(container,errors){
      container[qs]('#phoneError').innerText = errors.length ? errors[0] : ''
      container.classList.toggle('invalid',!!errors.length)
      container.classList.toggle('valid',!errors.length)
   }
   enableButton(container,errors){
      const button = container.closest('.box')[qs]('#callme')
      button.disabled = !!errors.length
   }
   onKeyUpPhone({target}) {
      const container = target.closest('.input-container');
      const errors = new PhoneValidator({
         value:target.value,
         required:true,
         min:11,
         max:19,
      })
      this.showErrors(container,errors)
      this.enableButton(container,errors)

   }

   getPhoneInput() {
      return (new FieldBuilder)
         .id('phone')
         .placeholder('Тел.')
         .required()
         .name('phone')
         .type('text')
         .errorEl('#phoneError')
         .badgeWidth('65px')
         .onKeyUp(this.onKeyUpPhone.bind(this))
         .get()
   }

   getCallMeButton() {
      const button = this.createButton("Заказать звонок")
      button.disabled = true
      button.addEventListener('click', this.callme.bind(this))
      return button
   }

   getLoginWarning() {
      return (new createElement()).tag('p').text("Оставляя свои данные, вы соглашаетесь с политикой конфиденциальности").get()
   }

   createButton(text) {
      return (new createElement()).tag('button').attr('type', 'submit').attr('class', 'button').attr('id', 'callme').text(text).get()
   }


   async callme(e) {
      YM('click_on_callme')
      const res = await post('/callme', this.authDTO(e));
      const content = e.target.closest('.content')
      if (res?.arr?.success) {
         content.innerHTML =
            '<p>-Ждите звонка на указанный номер.</p>'
      } else {
         content.innerHTML = res?.arr?.error ?? 'Неизвестная ошибка';
      }
   }


   authDTO(e) {
      e.preventDefault()
      const form = e.target.closest('.box')
      return {
         phone: sanitizeInput(form[qs]('input#phone')?.value) ?? null,
         php_session: getPhpSession() ?? null
      }
   }

}