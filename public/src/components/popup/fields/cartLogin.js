import FieldBuilder from "./FieldBuilder";

export default class cartLogin {
  constructor() {
    this.fields = this.setFields();
    this.title = 'Вход'
  }

  setFields() {
    let email = new FieldBuilder();
    email = email.class('email')
      .required()
      .placeholder('email');

    let password = new FieldBuilder();
    password = password.class('password')
      .required()
      .placeholder('пароль');
    return {email, password}
  }

}