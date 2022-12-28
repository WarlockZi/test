import './card.scss'
// import qui from '../components/quill/quill'
import {$} from '../common'

window.onload = function () {

  let quillSelector = '#dtxt'
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
