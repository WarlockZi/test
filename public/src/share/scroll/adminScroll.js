import {$} from "../../common.js";
export default function adminScroll() {

   const adminPanel = $('.admin-panel').first()

   document.addEventListener(
      'scroll',
      handle.bind(adminPanel),
      {passive: true}
   );

   function handle(){
      if (adminPanel)
         window.scrollY > 40 ? adminPanel.classList.add('fixed') : adminPanel.classList.remove('fixed')
   }
}
