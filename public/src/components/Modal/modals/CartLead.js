import FieldBuilder from "../builders/FieldBuilder";
import {createElement, getPhpSession, post, sanitizeInput} from "../../../common";


export default class CartLead {
   constructor() {
      this.content = []
      this.content.push((new FieldBuilder())
         .id('name')
         .badgeWidth('150px')
         .required()
         .placeholder('как к Вам обращаться')
         .pattern('[а-яА-Я]{1,}')
         .get()
      );
      this.content.push((new FieldBuilder)
         .id('company')
         .badgeWidth('175px')
         .required()
         .placeholder('название Вашей компании')
         .pattern('[a-zA-Zа-яА-я\\s()]{3,}')
         .get()
      );
      this.content.push((new FieldBuilder)
         .id('phone')
         .badgeWidth('130px')
         .required()
         .placeholder('сотовый для связи')
         .pattern('[0-9-+_()]{6,17}')
         .get()
      );

      this.content.push((new createElement())
         .tag('div')
         .attr('class', 'button')
         .text('Отправляя данные, вы соглашаетесь на обработку персональных данных')
         .get()
      );

   }

}