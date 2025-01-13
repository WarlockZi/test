import Modal from "@src/components/Modal/modal.js";
import CartLogin from "@src/Auth/CartLogin.js";
import CallMeModal from "@src/CallMe/CallMeModal.js";

export default class CallMe{
   constructor() {
      new Modal({
         triggers: ['#call-me', '#fixed-call-me'],
         boxes: new CallMeModal(),
      });

   }
}