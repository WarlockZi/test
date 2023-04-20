import './popup.scss'
import {$} from '../common';


export default function popup() {
  debugger;
  let popup = {
    show:$('.popup-button').first(),
    close:$('.popup-close').first(),
    wrapper:$('.wrapper').first(),
    box:$('.popup-box').first(),
  };

  popup.show.addEventListener('click', show.bind(popup));
  popup.close.addEventListener('click', close.bind(popup));

  function show() {
    popup.wrapper.style.opacity = 1;
    popup.box.classList.remove('transform-out');
    popup.box.classList.add('transform-in');
    e.preventDefault();
  }

  function close() {
    popup.wrapper.style.opacity = 0;
    $('.popup-box').first().classList.remove('transform-in').add('transform-out');
    e.preventDefault();
  }
}