import FieldBuilder from "../builders/FieldBuilder";
import {createElement} from "../../../common";
import ModalContent from "./ModalContent";

export default class CartLead extends ModalContent{
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
      .pattern('[0-9-+_()]{6,17}')
      // .error('телефон состоит минимум из 10 цифр')
      .make()
    ;

    let company = (new FieldBuilder)
      .id('company')
      .badgeWidth('175px')
      .required()
      .placeholder('название Вашей компании')
      .pattern('[a-zA-Zа-яА-я\\s]{3,}')
      // .error('заполните, пожалуйста, название вашей компании')
      .make()
    ;
    this.fields =  {name, phone, company}
  }


}