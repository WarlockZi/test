import {$, slider} from '../common';

let category = $('.category').first()

if (category) {
  slider()
  let filters = $('.filters .wrap').first()
  filters.onchange = ({target}) => {
    let filter = target.closest('.filter')
    let input = filter.querySelector('input')
    let f = input.id
    new callMethod(f)

  }
}


class callMethod {
  constructor(func) {
    this.instoreEls = document.querySelectorAll(`.product[data-instore='0']`)
    this.priceEls = document.querySelectorAll(`.product[data-price='0']`)
    this.func = {
      'instore': 'instore',
      'price': 'price',
    };
    this._init(func);
  }

  _init(func) {
    this[this.func[func]]();
  }

  instore() {
    this.instoreEls.forEach((p) => {
      p.classList.toggle('show')
    })
  }

  price() {
    this.priceEls.forEach((p) => {
      p.classList.toggle('show')
    })
  }

}