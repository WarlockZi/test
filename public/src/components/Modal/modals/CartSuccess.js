import {createElement} from "../../../common";
import ModalContent from "./ModalContent";

export default class CartSuccess extends ModalContent{
  constructor() {
    super();
    this.title = 'Заказ принят в обработку';
    this.submitText = 'Успешно';
    // this.setContent();
    // this.setFooter();
  }

  setFooter() {
    this.footer.push((new createElement())
      .tag('div')
      .attr('id', 'submit')
      .attr('class', 'button')
      .text('ok')
      .build())

  }

  setContent() {
    this.content.push(new createElement()
      .tag('div')
      .attr('class', 'text')
      .text('Какое-то сообщение')
      .build()
    )
  }



}