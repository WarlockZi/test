import {$, post} from '../../common'
import Quill from "quill";
import "quill/dist/quill.core.css";
import 'quill/dist/quill.snow.css';
import 'quill/dist/quill.bubble.css';

export default class MyQuill {
   constructor(selector = '#detail-text', autosave = false, toolbar = false, editable = false, theme = 'snow', dto = null,) {
      if (!$(selector)) return false
      this.model = $('[data-model]').first()?.dataset?.model ?? dto?.model ?? null
      this.id = $('[data-model]').first()?.dataset?.id ?? dto?.id ?? null
      this.button = $('#button').first()
      this.selector = selector

      this.autosave = autosave
      this.editable = editable
      this.contents = $(selector).first().innerText ?? '\\n';

      this.toolbar = toolbar ? this.setToolbar() : false
      this.options = this.setOptions()
      this.dto = dto
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
         // theme: 'bubble',
         placeholder: 'Compose an epic...',
         modules: {
            toolbar: this.toolbar
         },
      };
   }

   init() {
      const quill = new Quill(this.selector, this.options);
      if (this.isJson(this.contents)) {
         const json = JSON.parse(this.contents + '\n');
         quill.setContents(json)
      } else {
         quill.setText(this.contents)
      }
      if (!this.editable) quill.enable(false)
      if (this.autosave) {
         quill.on('text-change', function (delta) {
            const id = quill.id
            const content = JSON.stringify(quill.getContents())
            const dto = this.dto(content)

            post(`/adminsc/${dto.model}/updateOrCreate`,
               dto
            )
         }.bind(this));
      }


      if (this.button) {
         this.button.addEventListener('click', function () {
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

   isJson(json) {
      try {
         JSON.parse(json);
         return true
      } catch (e) {
         return false;
      }
   }
}


