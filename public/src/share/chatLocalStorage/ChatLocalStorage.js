import {getPhpSession} from "@src/common.js";

export default class ChatLocalStorage {
   constructor() {
      if (!localStorage.getItem('vitex-chat-id')){
         localStorage.setItem('vitex-chat-id', getPhpSession());
      }
   }
}