import FieldBuilder from "./FieldBuilder";

export default class cartLogin {
  constructor() {
    this.fields = this.setFields();
    this.title = 'Данные для связи'
  }

  setFields() {
    let name = new FieldBuilder('name');
    name = name
      .badgeWidth('150px')
      .required()
      .placeholder('как к Вам обращаться')
      .pattern('[а-яА-Я]{1,}')
      // .error('заполните, пожалуйста, ваше имя')
      .make()
    ;

    let phone = new FieldBuilder('phone');
    phone = phone
      .badgeWidth('130px')
      .required()
      .placeholder('сотовый для связи')
      .pattern('[0-9-_()]{10}')
      // .error('телефон состоит минимум из 10 цифр')
      .make()
    ;

    let company = new FieldBuilder('company');
    company = company
      .badgeWidth('175px')
      .required()
      .placeholder('название Вашей компании')
      .pattern('[а-яА-я]{1,}')
      // .error('заполните, пожалуйста, название вашей компании')
      .make()
    ;
    return {name, phone, company}
  }


}