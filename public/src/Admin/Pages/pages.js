import './pages.scss'
import MyQuill from "@src/components/quill/MyQuill.js";
import {$} from "@src/common.js";

export default class Pages {
   constructor() {
      this.setTabs()
      this.setPages()
      this.setQuils()

   }

   setTabs() {
      const tabs = $('.tab');
      tabs[0].classList.add('active');
      [].forEach.call(tabs, (tab) => {
         tab.addEventListener('click', (e) => {
            const id = e.target.dataset.id;
            $(`.page.active`).first().classList.remove('active')
            $(`.page[data-id='${id}']`).first().classList.add('active')
            $('.tab.active').first().classList.remove('active');
            e.target.classList.add('active');
         })
      })
   }

   setPages() {
      const pages = $('.page')
      pages[0].classList.add('active')
   }

   setQuils() {
      const quils = $(".quill[data-id]");
      quils[0].classList.add('active');
      [].forEach.call(quils, (quil) => {
         this.id = quil.dataset.id;
         new MyQuill(`.quill[data-id='${this.id}']`, true, true, true, 'snow', this.dto.bind(this));
      })
   }

   dto(change) {
      return {
         id: this.id,
         model: "pages",
         fields: {
            "content": change,
         }
      }
   }
}