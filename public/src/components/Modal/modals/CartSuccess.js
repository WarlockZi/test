import {createElement} from "../../../common";

export default class CartSuccess {
  constructor() {
    this.title = 'Заказ принят в обработку';
    this.submitText = 'Успешно';
    this.content = [];
    this.footer = [];
    // this.setContent();
    // this.setFooter();
  }

  setFooter() {
    this.footer.push((new createElement())
      .tag('div')
      .attr('id', 'submit')
      .attr('class', 'button')
      .text('ok')
      .make())

  }

  setContent() {
    this.content.push(new createElement()
      .tag('div')
      .attr('class', 'text')
      .text('Какое-то сообщение')
      .make()
    )
  }

}