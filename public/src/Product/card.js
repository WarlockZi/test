import './card.scss'
// import qui from '../components/quill/quill'
import {$} from '../common'

window.onload = function () {

  let selector = '#dtxt'

  let text = JSON.parse($(selector)[0].innerText)
  var options = {
    placeholder: 'Compose an epic...',
    // theme: 'bubble'
    // theme: 'snow'
  };
  var q = new Quill(selector, options);
  q.setContents(text)
  q.enable(false)




}
