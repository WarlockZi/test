import './card.scss'
import toCart from './toCart'

import {$, popup} from '../common'


window.onload = function () {

  new toCart();

  let zoom = $('.zoom').first();
  if (zoom) {

    zoom.onmousemove = function (e) {
      let offsetX = 0;
      let offsetY = 0;
      var zoomer = e.currentTarget;

      e.offsetX ? offsetX = e.offsetX : offsetX = e.touches[0].pageX;
      e.offsetY ? offsetY = e.offsetY : offsetX = e.touches[0].pageX;
      let x = offsetX / zoomer.offsetWidth * 100;
      let y = offsetY / zoomer.offsetHeight * 100;
      zoomer.style.backgroundPosition = x + '% ' + y + '%';
    }
  }

  const shortLink = $(`[data-shortLink]`).first()
  shortLink.addEventListener('click', async (e)=> {
    navigator.permissions.query({ name: "clipboard-write" }).then((result) => {
      if (result.state === "granted" || result.state === "prompt") {
        popup.show('Ссылка скопирована')
        navigator.clipboard.writeText(e.target.dataset.shortlink)
      }
    });
  })

  let quillSelector = '.detail-text';
  let textarea = $(quillSelector)[0];

  if (textarea) {
    let innertext = textarea.innerText;
    if (isJsonString(innertext)) {
      let text = JSON.parse(textarea.innerText);
      var options = {
        placeholder: 'Compose an epic...',
        // theme: 'bubble'
        // theme: 'snow'
      };

      var q = new Quill(quillSelector, options);
      q.setContents(text);
      q.enable(false)
    }
  }


  function isJsonString(str) {
    try {
      JSON.parse(str);
    } catch (e) {
      return false;
    }
    return true;
  }


};
