import {$} from "../../common.js";


export default function scroll() {

   const header = $('.header').first()

   document.addEventListener(
      'scroll',
      handle.bind(header),
      {passive: true}
   );

   function handle(){
         window.scrollY > 30 ? header.classList.add('short') : header.classList.remove('short')
   }
}
