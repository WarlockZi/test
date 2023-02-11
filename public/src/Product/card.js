import './card.scss'
// import '../Admin/Product/product.scss'

import {$} from '../common'

window.onload = function () {

  let quillSelector = '.detail-text'

  let textarea = $(quillSelector)[0]
  if (!textarea) return false

  let text = JSON.parse(textarea.innerText)
  var options = {
    placeholder: 'Compose an epic...',
    // theme: 'bubble'
    // theme: 'snow'
  };

  var q = new Quill(quillSelector, options);
  q.setContents(text)
  q.enable(false)




}
