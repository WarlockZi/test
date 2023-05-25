import FieldBuilder from "../builders/FieldBuilder";
import ModalContent from "./ModalContent";

export default class cartLogin  extends ModalContent{
  constructor() {
    super();
    this.title = 'Вход';
    this.submitText= 'Войти';
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
      .build();

    let password = (new FieldBuilder)
      .id('password')
      .required()
      .pattern('[a-zA-Z0-9-_()]{6,}')
      .badgeWidth('65px')
      .placeholder('пароль')
      .build();

    this.fields = {email, password}
  }

}