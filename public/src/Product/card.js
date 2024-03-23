import './card.scss'
import toCart from './toCart'
// import { convertHtmlToDelta } from 'node-quill-converter';
import {$, popup, post} from '../common'

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
  if (shortLink) {

    shortLink.addEventListener('click', async (e) => {
      navigator.permissions.query({name: "clipboard-write"}).then((result) => {
        if (result.state === "granted" || result.state === "prompt") {
          popup.show('Ссылка скопирована')
          navigator.clipboard.writeText(e.target.dataset.shortlink)
        }
      });
    })
  }

  let quillSelector = '.detail-text';
  let textarea = $(quillSelector)[0];

  // if (textarea) {
  //   let innertext = textarea.innerText;
  //   if (isJsonString(innertext)) {
  //     let text = JSON.parse(textarea.innerText);
  //   } else {
  //     let options = {
  //       placeholder: 'Compose an epic...',
  //       // theme: 'bubble'
  //       theme: 'snow'
  //     };
  //     var q = new Quill(quillSelector, options);
  //     q.enable()
  //     q.on('text-change', async function (delta, oldDelta, source) {
  //       debugger
  //       q.getText(textarea.innerText)
  //       let p = q.container.getElementsByTagName('p')
  //
  //       const d = { "ops": [
  //           { "insert": "Hello " },
  //           { "insert": "World", "attributes": { "bold": true } },
  //           { "insert": "\n" } ]
  //       }
  //
  //         textarea.html(q.getContents());



        // let text = textarea.innerText
        // let id = $('[data-field="id"]').first()
        // id = +id.innerText
        // let data = {
        //   id,
        //   txt: text
        // }
        // let res = await post(
        //   '/adminsc/product/updateOrCreate',
        //   data
        // )

      // });


    // }
  // }


  function isJsonString(str) {
    try {
      JSON.parse(str);
    } catch (e) {
      return false;
    }
    return true;
  }


};
