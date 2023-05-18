import {createElement} from "../../../common";

export default class CartSuccess {
  constructor() {
    this.title = 'Заказ принят в обработку';
    this.submitText = 'хрю хрю';
    this.content = [];
    this.footer = [];
    this.setContent();
    this.setFooter();
  }

  setFooter() {
    let builder = new createElement();
    this.footer.push(builder
      .tag('div')
      .attr('id', 'submit')
      .attr('class', 'button')
      .text('ok')
      .make())

  }

  setContent() {
    let builder = new createElement();
    this.content.push(builder
      .tag('div')
      .attr('class', 'text')
      .text('Body')
      .make()
    )
  }

}