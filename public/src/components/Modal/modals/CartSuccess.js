import {createElement} from "../../../common";


export default class CartSuccess {
  constructor() {

    this.content = []
    this.content.push(new createElement()
       .tag('div')
       .attr('class', 'text')
       .text('Какое-то сообщение')
       .get()
    )
    this.content.push((new createElement())
       .tag('div')
       .attr('id', 'submit')
       .attr('class', 'button')
       .text('ok')
       .get())
  }
}