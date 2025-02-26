import FieldBuilder from "../builders/FieldBuilder";
import {createElement} from "../../../common";
import Cart from "./Cart";

export default class CartLead extends Cart{
  constructor() {
    super();
    this.title = 'Данные для связи';
    this.submitText= 'отправить данные';
    this.setFields();
    this.setFooter();
  }

  setFooter(){
    this.footer.push((new createElement())
      .tag('div')
      .attr('class','button')
      .text('Отправляя данные, вы соглашаетесь на обработку персональных данных')
      .get())
  }

  setFields() {
    let name = (new FieldBuilder())
      .id('name')
      .badgeWidth('150px')
      .required()
      .placeholder('как к Вам обращаться')
      .pattern('[а-яА-Я]{1,}')
      // .error('заполните, пожалуйста, ваше имя')
      .get()
    ;

    let phone = (new FieldBuilder)
      .id('phone')
      .badgeWidth('130px')
      .required()
      .placeholder('сотовый для связи')
      .pattern('[0-9-+_()]{6,17}')
      // .error('телефон состоит минимум из 10 цифр')
      .get()
    ;

    let company = (new FieldBuilder)
      .id('company')
      .badgeWidth('175px')
      .required()
      .placeholder('название Вашей компании')
      .pattern('[a-zA-Zа-яА-я\\s()]{3,}')
      // .error('заполните, пожалуйста, название вашей компании')
      .get()
    ;
    this.fields =  {name, phone, company}
  }


}