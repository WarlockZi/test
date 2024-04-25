import '../404/404.scss'
import './main.scss'
// import ViteProxyWebsocket from 'vite-proxy-websocket'
import cart from '../Cart/cart'

import '../Category/category'
import {$} from "../common";
import Search from "../components/search/search";
import Promotions from '../Promotions/Promotion'

// import WebSocket from 'ws';
//
// const ws = new WebSocket('wss://localhost:3000');
// //
// debugger
// ws.onerror = console.error;
//
// ws.onopen = function open() {
//   ws.send('something');
// };
//
// ws.onmessage = function message(data) {
//   console.log('received: %s', data);
// }


document.addEventListener('DOMContentLoaded', function () {

  // debugger

  // const proxy = new ViteProxyWebsocket({target: 'ws://example.com', path: '/websocket'});

  // proxy.listen(3000);

  let gumburger = $('.gamburger')[0];
  if (gumburger) {
    $('.gamburger').on('click', opentMobilePanel)
  }
  new Promotions;


  function opentMobilePanel(e) {
    let mm = e.target.closest('.utils').querySelector('.mobile-menu');
    mm.classList.toggle('show')
  }


  new Search();
  new cart()
});


