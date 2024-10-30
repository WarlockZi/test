import FieldBuilder from "../builders/FieldBuilder";
import Cart from "./Cart";
import {emailValidator} from "../../../common.js";

export default class cartLogin extends Cart {
   constructor() {
      super();
      this.title = 'Вход';
      this.submitText = 'Войти';
      this.setFields();
      // this.setFooter();
   }

   setFields() {

      const email = (new FieldBuilder)
         .id('email')
         .required()
         .name('email')
         .type('text')
         .onInput(this.onInputEmail.bind(this))
         .errorEl('#emailError')
         .badgeWidth('55px')
         .placeholder('email')
         .get();

      const password = (new FieldBuilder)
         .id('password')
         .required()
         .name('password')
         .type('password')
         // .autocomplete()
         .badgeWidth('65px')
         .placeholder('пароль')
         .get();

      this.fields = {email, password}
   }

   onInputEmail({target}) {
      const email = target.value
      const errors = emailValidator(email)
      this.fields.email.querySelector('#emailError').innerText = errors.length ? errors[0] : ''
      this.fields.email.querySelector('input').style.outline = errors.length ? 'solid 1px #dc2f55' : 'solid 1px #2fdcdb'
      this.fields.email.querySelector('label').style.color = errors.length ? '#dc2f55' : '#2fdcdb'
   }


}