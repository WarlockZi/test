import FieldBuilder from "../builders/FieldBuilder";
import ModalContent from "./ModalContent";

export default class cartLogin  extends ModalContent{
  constructor() {
    super();
    this.title = 'Вход';
    this.submitText= 'Отправить';
    this.setFields();
    // this.setFooter();
  }

  setFields() {

    let email = (new FieldBuilder)
      .id('email')
      .required()
      .badgeWidth('55px')
      .type('email')
      .placeholder('email')
      .make();

    let password = (new FieldBuilder)
      .id('password')
      .required()
      .pattern('[a-zA-Z0-9-_()]{6,}')
      .badgeWidth('65px')
      .placeholder('пароль')
      .make();

    this.fields = {email, password}
  }

}