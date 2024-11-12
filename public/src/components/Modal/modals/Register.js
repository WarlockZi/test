import FieldBuilder from "../builders/FieldBuilder";

import {createElement, emailValidator, getPhpSession, post, sanitizeInput} from "../../../common.js";

export default class Register {
   constructor() {
      this.rows = []
      this.rows.push((new FieldBuilder)
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

      this.rows.push((new FieldBuilder)
         .id('password')
         .required()
         .name('password')
         .type('password')
         .badgeWidth('65px')
         .placeholder('пароль')
         .get()
      );
      this.rows.push(
         this.getRegisterButton()
      );
      this.rows.push(
         this.getLoginWarning()
      );
      this.rows.push(
         this.getLoginButton()
      );


   }
   getRegisterButton() {
      const registerButton = (new createElement()).tag('div').attr('class', 'button').attr('id', 'register').text("Регистрация").get()
      registerButton.addEventListener('click', this.login)
      return registerButton
   }
   getLoginWarning() {
      return (new createElement()).tag('p').text("Согласен").get()
   }
   getLoginButton() {
      const loginButton = (new createElement()).tag('div').attr('type', 'submit').attr('class', 'button').attr('id', 'submit').text("Войти").get()
      loginButton.addEventListener('click', this.register)
      return loginButton
   }

   async login(fields, modal) {
      const email = sanitizeInput(fields.email.value);
      const password = sanitizeInput(fields.password.value);
      const sess = getPhpSession();
      const res = await post('/cart/login', {email, password, sess});
      modal.close();
      if (res) {
         location.reload()
      }
   }
   async register(fields, modal) {
      const email = sanitizeInput(fields.email.value);
      const password = sanitizeInput(fields.password.value);
      const sess = getPhpSession();
      const res = await post('/cart/register', {email, password, sess});
      modal.close();
      if (res) {
         location.reload()
      }
   }
   onInputEmail({target}) {
      const email = target.value
      const errors = emailValidator(email)
      target.querySelector('#emailError').innerText = errors.length ? errors[0] : ''
      target.querySelector('input').style.outline = errors.length ? 'solid 1px #dc2f55' : 'solid 1px #2fdcdb'
      target.querySelector('label').style.color = errors.length ? '#dc2f55' : '#2fdcdb'
   }


}