import {createElement} from "../../../common";
import Cart from "./Cart";

export default class CartSuccess extends Cart{
  constructor() {
    super();
    this.title = 'Заказ принят в обработку';

    this.content.push(new createElement()
       .tag('div')
       .attr('class', 'text')
       .text('Какое-то сообщение')
       .get()
    )
    this.footer.push((new createElement())
       .tag('div')
       .attr('id', 'submit')
       .attr('class', 'button')
       .text('ok')
       .get())
  }
}