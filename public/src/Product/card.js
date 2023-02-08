import './card.scss'

import {$} from '../common'

window.onload = function () {

  let quillSelector = '.detail-text'
  if (!$(quillSelector)[0]) return false

  let text = JSON.parse($(quillSelector)[0].innerText)
  var options = {
    placeholder: 'Compose an epic...',
    // theme: 'bubble'
    // theme: 'snow'
  };

  var q = new Quill(quillSelector, options);
  q.setContents(text)
  q.enable(false)




}
