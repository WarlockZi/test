import {$, post} from '../../common'
import Quill from "quill";
import "quill/dist/quill.core.css";
import 'quill/dist/quill.snow.css';

export default class MyQuill {
   constructor(selector = '#detail-text') {

      this.selector = selector
      this.textarea = $(selector)[0]
      if (!this.textarea) return false
      this.toolbar = this.setToolbar()
      this.options = this.setOptions()
      this.init()

   }

   setToolbar() {
      return [
         ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
         ['blockquote'],

         // [{ 'header': 1 }, { 'header': 2 }],               // custom button values
         [{'list': 'ordered'}, {'list': 'bullet'}],
         [{'script': 'sub'}, {'script': 'super'}],      // superscript/subscript
         [{'indent': '-1'}, {'indent': '+1'}],          // outdent/indent
         // [{ 'direction': 'rtl' }],                         // text direction

         [{'size': ['small', false, 'large', 'huge']}],  // custom dropdown
         // [{ 'header': [1, 2, 3, 4, 5, 6, false] }],

         [{'color': []}, {'background': []}],          // dropdown with defaults from theme
         [{'font': []}],
         [{'align': []}],

         ['clean']                                         // remove formatting button
      ];
   }

   setOptions() {
      return {
         theme: 'snow',
         // theme: 'bubble'
         placeholder: 'Compose an epic...',
         modules: {
            toolbar: this.toolbar
         },
      };
   }


   init() {
      const text = this.textarea.innerText.trim()

      const quill = new Quill(this.selector, this.options);

      try {
         const json = JSON.parse(text);
         quill.setContents(json)
      } catch (e) {
      }

      this.textarea.style.background = '#fff'

      const button = $('#button')[0]
      if (button) {
         button.addEventListener('click', function () {

               const productId = $(`.item-wrap[data-model='product']`)[0].dataset.id
               const txt = JSON.stringify(quill.getContents())

               post('/adminsc/product/updateOrCreate',
                  {
                     txt,
                     'id': productId
                  }
               ).then()
            }
         )
      }
   }
}


