import {$} from '../common';

let category = $('.category').first()

if (category) {
  let filters = $('.filters').first()
  filters.onclick = function () {
    if (!this.style.height) {
      this.style.height = this.scrollHeight + 'px'
    } else {
      this.style.height = ''
    }
  }
}