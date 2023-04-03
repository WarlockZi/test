import './card.scss'

import {$} from '../common'


window.onload = function () {

  let img = $('.zoom').first()
  img.onmousemove = function (e) {
    let offsetX = 0
    let offsetY = 0
    var zoomer = e.currentTarget;

    e.offsetX ? offsetX = e.offsetX : offsetX = e.touches[0].pageX
    e.offsetY ? offsetY = e.offsetY : offsetX = e.touches[0].pageX
    let x = offsetX / zoomer.offsetWidth * 100
    let y = offsetY / zoomer.offsetHeight * 100
    zoomer.style.backgroundPosition = x + '% ' + y + '%';
  }


  let quillSelector = '.detail-text'

  let innertext = $(quillSelector)[0].innerText

  if (isJsonString(innertext)) {
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


  function isJsonString(str) {
    try {
      JSON.parse(str);
    } catch (e) {
      return false;
    }
    return true;
  }


}
