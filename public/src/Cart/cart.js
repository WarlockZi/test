import './cart.scss'
import {$, post} from '../common'

export default class Cart {
  constructor() {
    let container = $('.user-content .cart').first();
    if (!container) return;
    this.container = container;
    this.rows = container.querySelectorAll('.row');
    this.container.onclick = this.handleClick
  }

  getRows() {
    let rows = [].map.call(this.rows, (row) => {
      return {
        id: row.querySelector('.name').dataset['1sid'],
        count: row.querySelector('.count').value
      }
    });
    return rows
  }


  async handleClick({target}) {
    if (target.classList.contains('del')) {
      let row = target.closest('.row');
      let id = row.querySelector('.name').dataset['1sid'];

      let res = await post(`/adminsc/orderItem/delete`, {id});
      if (res.arr.ok) {
        row.remove()
      }


    } else if (target.classList.contains('d')) {

    }
  }

}