import FieldBuilder from "../builders/FieldBuilder";
import {createElement} from "../../../common";

export default class CartLead {
  constructor() {
    this.footer = [];
    this.content = [];
    this.fields = [];

    this.title = 'Данные для связи';
    this.submitText= 'отправить Kea';
    this.setFields();
    this.setFooter();
  }

  setFooter(){
    let builder = new createElement();
    this.footer.push(builder
      .tag('div')
      .attr('class','button')
      .text('Отправить Lead')
      .make())
  }

  setFields() {
    let name = (new FieldBuilder())
      .id('name')
      .badgeWidth('150px')
      .required()
      .placeholder('как к Вам обращаться')
      .pattern('[а-яА-Я]{1,}')
      // .error('заполните, пожалуйста, ваше имя')
      .make()
    ;

    let phone = (new FieldBuilder)
      .id('phone')
      .badgeWidth('130px')
      .required()
      .placeholder('сотовый для связи')
      .pattern('[0-9-_()]{10}')
      // .error('телефон состоит минимум из 10 цифр')
      .make()
    ;

    let company = (new FieldBuilder)
      .id('company')
      .badgeWidth('175px')
      .required()
      .placeholder('название Вашей компании')
      .pattern('[а-яА-я]{1,}')
      // .error('заполните, пожалуйста, название вашей компании')
      .make()
    ;
    this.fields =  [name, phone, company]
  }


}