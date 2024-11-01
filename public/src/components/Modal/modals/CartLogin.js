import FieldBuilder from "../builders/FieldBuilder";
import Cart from "./Cart";
import {emailValidator} from "../../../common.js";

export default class cartLogin extends Cart {
   constructor() {
      super();
      this.title = 'Вход';
      this.fields.push((new FieldBuilder)
         .id('email')
         .required()
         .name('email')
         .type('text') //not email as in transforms cyrillic to punicode
         .onInput(this.onInputEmail.bind(this))
         .errorEl('#emailError')
         .badgeWidth('55px')
         .placeholder('email')
         .get()
      );

      this.fields.push((new FieldBuilder)
         .id('password')
         .required()
         .name('password')
         .type('password')
         // .autocomplete()
         .badgeWidth('65px')
         .placeholder('пароль')
         .get()
      );
      this.submitText = 'Войти';

   }


   onInputEmail({target}) {
      const email = target.value
      const errors = emailValidator(email)
      this.fields.email.querySelector('#emailError').innerText = errors.length ? errors[0] : ''
      this.fields.email.querySelector('input').style.outline = errors.length ? 'solid 1px #dc2f55' : 'solid 1px #2fdcdb'
      this.fields.email.querySelector('label').style.color = errors.length ? '#dc2f55' : '#2fdcdb'
   }


}