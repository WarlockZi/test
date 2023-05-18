import FieldBuilder from "../builders/FieldBuilder";

export default class cartLogin {
  constructor() {
    this.setFields();
    this.title = 'Вход'
  }

  setFields() {
    let email = new FieldBuilder('email');
    email = email
      .required()
      .badgeWidth('55px')
      .type('email')
      .placeholder('email')
      .make();

    let password = new FieldBuilder('password');
    password = password
      .required()
      .pattern('[a-zA-Z0-9-_()]{6,}')
      .badgeWidth('65px')
      .placeholder('пароль')
      .make();
    this.fields = {email, password}
  }

}