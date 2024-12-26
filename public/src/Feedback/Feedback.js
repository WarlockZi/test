import './feedback.scss';
import {ael, qa, qs} from "@src/constants.js";
import stripjs from 'strip-js';
import {debounce, emailValidator, post} from "@src/common.js";


export default class Feedback {
   constructor(button) {
      if (!button) return false

      this.button = button

      this.formWrapper = button.closest('.feedback')
      this.form = this.formWrapper[qs]('form')
      this.title = this.formWrapper[qs]('.feedback-title')
      this.checkmark = this.formWrapper[qs]('.check-icon')
      this.inputs = this.formWrapper[qa]('.input-container input')

      this.setInputs()
      this.setErrorTags()

      this.formWrapper[ael]('submit', this.handleSubmit.bind(this))
      this.formWrapper[ael]('keyup', debounce(this.handelKeyup.bind(this), 1000))
   }


   async handelKeyup({target}) {
      if (target.tagName === 'INPUT') {
         const {emailValidator, phoneValidator} = await import('@src/common.js')
         if (target.id === 'name') {
            const nameErr = stripjs(target.value)
         } else if (target.id === 'email') {
            this.emailError.innerText = emailValidator(target.value)[0] ?? ''
         } else if (target.id === 'phone') {
            const phoneErr = phoneValidator(target.value)[0] ?? ''
            this.phoneError.innerText = phoneValidator(target.value)[0] ?? ''
         } else if (target.id === 'message') {
            const messageErr = stripjs(target.value)
         }
      }
   }


   async handleSubmit(e) {
      e.preventDefault()

      const {emailValidator, phoneValidator} = await import('@src/common.js')
      if (emailValidator(this.email.value).length
         || phoneValidator(this.phone.value).length) return
      const res = await post('/feedback/updateOrCreate', this.dto())
      if (res?.arr?.id) {
         this.title.innerText = 'Сообщение отправлено'
         this.title.classList.add('sent')
         this.checkmark.classList.remove('none')
         setTimeout(function () {
            this.form.reset()
            this.checkmark.classList.add('none')
            this.title.classList.remove('sent')
            this.title.innerText = 'Напишите свой вопрос';
         }.bind(this), 2_000)

      }

   }

   dto() {
      return {
         id: 0,
         fields: {
            name: stripjs(this.name.value),
            email: stripjs(this.email.value),
            phone: stripjs(this.phone.value),
            message: stripjs(this.message.value),
            // phpSession: getPhpSession()
         }
      }
   }

   setInputs() {
      this.name = this.formWrapper[qs]('#name')
      this.email = this.formWrapper[qs]('#email')
      this.phone = this.formWrapper[qs]('#phone')
      this.message = this.formWrapper[qs]('#message')
   }

   setErrorTags() {
      this.nameError = this.formWrapper[qs]('#nameError')
      this.emailError = this.formWrapper[qs]('#emailError')
      this.phoneError = this.formWrapper[qs]('#phoneError')
      this.messageError = this.formWrapper[qs]('#messageError')
   }
}