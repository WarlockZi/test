import Modal from "@components/Modal/modal.js";
import CallMeModal from "@src/Modules/main/call_me/CallMeModal.js";

export default class Call_me {
  constructor() {
    new Modal({
      triggers: ["#call-me", "#fixed-call-me", "#burger-call-me"],
      boxes: new CallMeModal(),
    });
  }
}
