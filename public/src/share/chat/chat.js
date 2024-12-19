import './chat.scss';
import {ael, qs} from "@src/constants.js";
import {createElement, post} from "@src/common.js";

export default class Chat {
   constructor() {
      this.icon = document[qs]('.chat-icon');
      this.form = document[qs]('#chatForm');
      this.messages = this.form[qs]('.messages');
      this.input = this.form[qs]('input');
      this.icon?this.icon[ael]('click', this.iconClickHandler.bind(this)):'';
      this.form[ael]('click', this.formClickHandler.bind(this));
      this.form[ael]('keyup', this.handleKeyup.bind(this));
      this.user = this.getUser()
   }

   getUser() {
      const vitexChatId = this.getChatId();
   }

   handleKeyup(e) {
      if (e.key === 'Enter' || e.keyCode === 13) {
         if (e.target.dataset.userName) {

         } else if (e.target.dataset.message) {
         }
      }

   }

   iconClickHandler({target}) {
      this.form.classList.add('open')
      this.newChat()
   }

   formClickHandler({target}) {
      if (target.classList.contains('modal-close')) {
         this.form.classList.remove('open');
      } else if (target) {
      }
   }

   async newChat() {
      const chatId = {
         chatId: this.getChatId(),
      }
      const res = await post('/chat/newChat', chatId)
      if (!res?.arr?.user_name) {
         this.renderMessages(res.arr.messages)
         delete this.input.dataset.userName
         this.input.dataset.message = ''
         this.input.setAttribute('placeholder', 'Сообщение')
      }
   }

   async renderMessages(messages) {
      for (let message of messages) {
         const user = message.user_id
         const manager = message.manager_id
         const mess = this.getMessage(user, message)
         this.messages.append(mess)
      }
   }

   getMessage(user, message) {
      return user
         ? (new createElement()).tag('div').attr('class', 'message user').text(message.message).get()
         : (new createElement()).tag('div').attr('class', 'message manager').text(message.message).get()
   }

   getChatId() {
      return window.localStorage.getItem('vitex-chat-id');
   }
}