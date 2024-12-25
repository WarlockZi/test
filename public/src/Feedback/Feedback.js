import './feedback.scss';
import {ael, qa, qs} from "@src/constants.js";
import stripjs from 'strip-js';
import {debounce} from "@src/common.js";


export default class Feedback {
   constructor(button) {
      if (!button) return false

      this.button = button

      this.form = button.closest('.feedback')
      this.inputs = this.form[qa]('.input-container input')

      this.setInputs()
      this.setErrorTags()

      this.button[ael]('submit', this.handleSubmit.bind(this))
      this.form[ael]('keyup', debounce(this.handelKeyup.bind(this), 1800))
   }


   async handelKeyup({target}) {
      if (target.tagName === 'INPUT') {
         const {emailValidator, phoneValidator} = await import('@src/common.js')
         if (target.id === 'name') {
            const nameErr = stripjs(target.value)
         } else if (target.id === 'email') {
            const emailErr = emailValidator(target.value)
            this.emailError.innerText = emailValidator(target.value)[0]
         } else if (target.id === 'phone') {
            const phoneErr = phoneValidator(target.value)
         } else if (target.id === 'message') {
            const messageErr = stripjs(target.value)
         }
      }
   }


   handleSubmit(e) {
      e.preventDefault()
   }

   setInputs() {
      this.name = this.form[qs]('#name')
      this.email = this.form[qs]('#email')
      this.phone = this.form[qs]('#phone')
      this.message = this.form[qs]('#message')
   }

   setErrorTags() {
      this.nameError = this.form[qs]('#nameError')
      this.emailError = this.form[qs]('#emailError')
      this.phoneError = this.form[qs]('#phoneError')
      this.messageError = this.form[qs]('#messageError')
   }
}