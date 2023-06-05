import FieldBuilder from "../builders/FieldBuilder";
import Cart from "./Cart";

export default class cartLogin  extends Cart{
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
      .name('email')
      .autocomplete()
      .badgeWidth('55px')
      .type('email')
      .placeholder('email')
      .get();

    let password = (new FieldBuilder)
      .id('password')
      .required()
      .name('password')
      .autocomplete()
      .pattern('[a-zA-Z0-9-_()]{6,}')
      .badgeWidth('65px')
      .placeholder('пароль')
      .get();

    this.fields = {email, password}
  }

}