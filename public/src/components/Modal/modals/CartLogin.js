import FieldBuilder from "../builders/FieldBuilder";

import {createElement, emailValidator, getPhpSession, post, sanitizeInput} from "../../../common.js";
import {qs} from "@src/constants.js";

export default class cartLogin {
   constructor() {
      return  {
         1: [this.getLoginRows()],
         2: [this.getRegisterRows()],
         3: [this.getForgotRows()]
      }
   }

   getLoginRows() {
      return[
         'Вход',
         this.getEmailInput(),
         this.getPasswordInput(),
         this.getLoginButton(),
         this.createLinks('login'),
         this.getLoginWarning(),
      ]
   }
   getRegisterRows() {
      return[
         "Регистрация",
         this.getEmailInput(),
         this.getPasswordInput(),
         this.getPhoneInput(),
         this.getRegisterButton(),
         this.createLinks('register'),
         this.getLoginWarning(),
      ]
   }
   getForgotRows() {
      return[
         "Восстановление пароля",
         this.getEmailInput(),
         this.getForgotButton(),
         this.createLinks('forgot'),
         this.getLoginWarning(),
      ]
   }
   getEmailInput() {
      return (new FieldBuilder)
         .id('email')
         .required()
         .name('email')
         .type('text') //not email as in transforms cyrillic to punicode
         .onInput(this.onInputEmail.bind(this))
         .errorEl('#emailError')
         .badgeWidth('55px')
         .placeholder('email')
         .get()
   }
   getPasswordInput() {
      return (new FieldBuilder)
         .id('password')
         .required()
         .name('password')
         .type('password')
         .badgeWidth('65px')
         .placeholder('пароль')
         .get()
   }
   getPhoneInput() {
      return (new FieldBuilder)
         .id('phone')
         .required()
         .name('phone')
         .type('text')
         .badgeWidth('65px')
         .placeholder('телефон')
         .get()
   }


   getLoginButton() {
      const loginButton = this.createButton("Войти")
      loginButton.addEventListener('click', this.login.bind(this))
      return loginButton
   }
   getRegisterButton() {
      const registerButton = this.createButton("Регистрация")
      registerButton.addEventListener('click', this.register.bind(this))
      return registerButton
   }
   getForgotButton() {
      const forgotPassword = this.createButton("Забыл пароль")
      forgotPassword.addEventListener('click', this.forgot.bind(this))
      return forgotPassword
   }


   getLoginLink() {
      const loginButton = this.createLink("Войти",1)
      loginButton.addEventListener('click', this.switch.bind(this))
      return loginButton
   }
   getRegisterLink() {
      const registerButton = this.createLink("Регистрация",2)
      registerButton.addEventListener('click', this.switch.bind(this))
      return registerButton
   }
   getForgotLink() {
      const forgotPassword = this.createLink("Забыл пароль",3)
      forgotPassword.addEventListener('click', this.switch.bind(this))
      return forgotPassword
   }


   getLoginWarning() {
      return (new createElement()).tag('p').text("Оставляя свои данные, вы соглашаетесь с политикой конфиденциальности").get()
   }
   createLink(text, dataTarget){
      return (new createElement()).tag('div').attr('class', 'link').attr('data-target', dataTarget).text(text).get()
   }
   createLinks(type){
      const wrap = (new createElement()).tag('div').attr('class','row').get()
      if (type==='register'){
         wrap.appendChild(this.getLoginLink())
         wrap.appendChild(this.getForgotLink())
      }
      else if(type==='login'){
         wrap.appendChild(this.getRegisterLink())
         wrap.appendChild(this.getForgotLink())
      }
      else if(type==='forgot'){
         wrap.appendChild(this.getLoginLink())
         wrap.appendChild(this.getRegisterLink())
      }
      return wrap
   }
   switch({target},type) {
      const event = new Event('modal.switch', {bubbles: true})
      target.dispatchEvent(event)
   }
   createButton(text){
      return (new createElement()).tag('button').attr('type', 'submit').attr('class', 'button').attr('id', 'forgot').text(text).get()
   }
   async login(e) {
      e.preventDefault()
      const form = e.target.closest('.box')
      const email = sanitizeInput(form[qs]('input#email').value);
      const password = sanitizeInput(form[qs]('input#password').value);
      const sess = getPhpSession();
      const res = await post('/auth/login', {email, password, sess});
      if (res) {
         location.reload()
      }
   }
   async register({target}) {

   }
   async forgot({target}) {

   }

   onInputEmail({target}) {
      const container = target.closest('.input-container');
      const email = target.value
      const errors = emailValidator(email)
      container.querySelector('#emailError').innerText = errors.length ? errors[0] : ''
      container.querySelector('label').style.color = errors.length ? '#dc2f55' : '#2fdcdb'
      target.style.outline = errors.length ? 'solid 1px #dc2f55' : 'solid 1px #2fdcdb'
   }
}