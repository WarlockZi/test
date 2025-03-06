import Modal from "@src/components/Modal/modal.js";
import CallMeModal from "@src/CallMe/CallMeModal.js";

export default class CallMe{
   constructor() {
      new Modal({
         triggers: ['#call-me', '#fixed-call-me', '#burger-call-me'],
         boxes: new CallMeModal(),
      });

   }
}