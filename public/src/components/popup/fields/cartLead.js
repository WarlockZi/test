import FieldBuilder from "./FieldBuilder";

export default class cartLogin {
  constructor() {
    this.fields = this.setFields();
    this.title = 'Данные для связи'
  }

  setFields() {
    let name = new FieldBuilder();
    name = name.class('name')
      .required()
      .placeholder('Как к Вам обращаться')
      .pattern('[а-яА-Я]{1,}')
      .error('заполните, пожалуйста, ваше имя');

    let phone = new FieldBuilder();
    phone = phone.class('phone')
      .required()
      .placeholder('сотовый для связи')
      .pattern('[0-9-_()]{10}')
      .error('телефон состоит минимум из 10 цифр');

    let company = new FieldBuilder();
    company = company.class('company')
      .required()
      .placeholder('название Вашей компании')
      .pattern('[а-яА-я]{1,}')
      .error('заполните, пожалуйста, название вашей компании');
    return {name, phone, company}
  }


}