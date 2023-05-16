import FieldBuilder from "./FieldBuilder";

export default class cartLogin {
  constructor() {
    this.fields = this.setFields();
    this.title = 'Вход'
  }

  setFields() {
    let email = new FieldBuilder('email');
    debugger;
    email = email
      .required()
      // .pattern(
      //   '^(([^<>()[\\]\\.,;:\\s@\\"]+(\\.[^<>()[\\]\\.,;:\\s@\\"]+)*)|(\\".+\\"))@(([^<>()[\\]\\.,;:\\s@\\"]+\\.)+[^<>()[\\]\\.,;:\\s@\\"]{2,})$')
        // "^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$")
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
    return {email, password}
  }

}