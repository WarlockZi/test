import FieldBuilder from "../components/Modal/builders/FieldBuilder.js";

import {createElement, emailValidator, passwordValidator,getPhpSession, post, sanitizeInput} from "../common.js";
import {qs} from "@src/constants.js";

export default class cartLogin {
   constructor() {
      return {
         1: [this.getLoginRows()],
         2: [this.getRegisterRows()],
         3: [this.getForgotRows()]
      }
   }

   getLoginRows() {
      return [
         'Вход',
         this.getEmailInput(),
         this.getPasswordInput(),
         this.getLoginButton(),
         this.createLinks('login'),
         this.getYandexAuth(),
         this.getLoginWarning(),
      ]
   }

   getRegisterRows() {
      return [
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
      return [
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
         .errorEl('#emailError')
         .onInput(this.onInputPassword.bind(this))
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
         .errorEl('#emailError')
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
      const loginButton = this.createLink("Войти", 1)
      loginButton.addEventListener('click', this.switch.bind(this))
      return loginButton
   }

   getRegisterLink() {
      const registerButton = this.createLink("Регистрация", 2)
      registerButton.addEventListener('click', this.switch.bind(this))
      return registerButton
   }

   getForgotLink() {
      const forgotPassword = this.createLink("Забыл пароль", 3)
      forgotPassword.addEventListener('click', this.switch.bind(this))
      return forgotPassword
   }

   getYandexAuth() {
      return (new createElement()).tag('a').attr('href', 'https://oauth.yandex.ru/authorize?' +
         'client_id=1cacd478c22b49c1a22e59ac811d0fc0&' +
         'redirect_uri=https://vitexopt.ru/auth/yandex&' +
         'response_type=code&' +
         'state=132').attr('class', 'yandex').attr('title', 'Авторизация Яндекс').get()
   }

   getLoginWarning() {
      return (new createElement()).tag('p').text("Оставляя свои данные, вы соглашаетесь с политикой конфиденциальности").get()
   }

   createLink(text, dataTarget) {
      return (new createElement()).tag('div').attr('class', 'link').attr('data-target', dataTarget).text(text).get()
   }

   createLinks(type) {
      const wrap = (new createElement()).tag('div').attr('class', 'row').get()
      if (type === 'register') {
         wrap.appendChild(this.getLoginLink())
         wrap.appendChild(this.getForgotLink())
      } else if (type === 'login') {
         wrap.appendChild(this.getRegisterLink())
         wrap.appendChild(this.getForgotLink())
      } else if (type === 'forgot') {
         wrap.appendChild(this.getLoginLink())
         wrap.appendChild(this.getRegisterLink())
      }
      return wrap
   }

   switch({target}, type) {
      const event = new Event('modal.switch', {bubbles: true})
      target.dispatchEvent(event)
   }

   createButton(text) {
      return (new createElement()).tag('button').attr('type', 'submit').attr('class', 'button').attr('id', 'forgot').text(text).get()
   }

   async login(e) {
      YM('click_on_login')
      const dto = this.authDTO(e)
      const res = await post('/auth/login', dto);
      if (res?.arr) {
         const content = e.target.closest('.content')
         content.innerHTML = 'Вход выполнен'

         const id = res?.arr?.id
         localStorage.setItem('id', id)
         if (res?.arr?.role === 'employee') {
            window.location = '/adminsc'
         } else if (res?.arr?.role === 'guest') {
            window.location = '/auth/profile'
         } else if (res?.arr?.role === 'admin') {
            window.location = '/adminsc'
         } else if (res?.error) {
         }
      }
   }

   async register(e) {
      YM('click_on_register')
      const res = await post('/auth/register', this.authDTO(e));
      const content = e.target.closest('.content')
      if (res?.arr?.success) {
         content.innerHTML =
            '-Пользователь зарегистрирован.<br>' +
            '-Для подтверждения регистрации зайдите на почту, ' +
            '<bold>email.</bold>' +
            '-Перейдите по ссылке в письме.'
      } else if (res?.arr?.error === 'mail exists') {
         content.innerHTML = 'Эта почта уже зарегистрирована. Войдите в систему по кнопке внизу Войти или, если не помните пароль, восстановите пароль по кнопке Забыл пароль';

      } else {
         content.innerHTML = res?.arr?.error??'Неизвестная ошибка';
      }
   }

   async forgot(e) {
      const dto = this.authDTO(e)
      const res = await post('/auth/returnpass', dto);
      if (res?.arr?.success) {
         const content = e.target.closest('.content')
         content.innerHTML = 'Новый пароль отпарвлен на почту'
      }
   }

   authDTO(e) {
      e.preventDefault()
      const form = e.target.closest('.box')
      const email = sanitizeInput(form[qs]('input#email')?.value) ?? null;
      const password = sanitizeInput(form[qs]('input#password')?.value) ?? null;
      const phone = sanitizeInput(form[qs]('input#phone')?.value) ?? null;
      const sess = getPhpSession() ?? null;
      return {email, password, phone, sess}
   }

   onInputEmail({target}) {
      const container = target.closest('.input-container');
      const email = target.value
      const errors = emailValidator(email)
      container.querySelector('#emailError').innerText = errors.length ? errors[0] : ''
      container.querySelector('label').style.color = errors.length ? '#dc2f55' : '#2fdcdb'
      target.style.outline = errors.length ? 'solid 1px #dc2f55' : 'solid 1px #2fdcdb'
   }
   onInputPassword({target}) {
      const container = target.closest('.input-container');
      const pass = target.value
      const errors = passwordValidator(pass)
      container.querySelector('#emailError').innerText = errors.length ? errors[0] : ''
      container.querySelector('label').style.color = errors.length ? '#dc2f55' : '#2fdcdb'
      target.style.outline = errors.length ? 'solid 1px #dc2f55' : 'solid 1px #2fdcdb'
   }
}