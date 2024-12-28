import {$, IsJson, post} from '../../common'
import Quill from "quill";
import "quill/dist/quill.core.css";
import 'quill/dist/quill.snow.css';
import 'quill/dist/quill.bubble.css';
import DTO from "@src/Admin/DTO.js";

export default class MyQuill {
   constructor(selector = '#detail-text', autosave = false, toolbar = false, editable = false, theme = 'snow', dto = null,) {
      const el = $(selector).first()
      if (!el) return false
      this.el = el
      this.model = $('[data-model]').first()?.dataset?.model ?? dto?.model ?? null
      this.id = this.model?.dataset?.id ?? dto?.id ?? null
      this.button = $('#button').first()
      this.selector = selector

      this.autosave = autosave
      this.editable = editable
      this.contents = $(selector).first().innerText ?? '\\n';

      this.toolbar = toolbar ? this.setToolbar() : false
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
         // theme: 'bubble',
         placeholder: 'Начните писать...',
         modules: {
            toolbar: this.toolbar
         },
      };
   }

   dto() {
      return new DTO(this.id, this.el)
   }

   init() {
      this.quill = new Quill(this.selector, this.options);
      if (IsJson(this.contents)) {
         const json = JSON.parse(this.contents + '\n');
         this.quill.setContents(json)
      } else {
         this.quill.setText(this.contents)
      }
      if (!this.editable) this.quill.enable(false)
      if (this.autosave) {
         this.quill.on('text-change', function (delta) {
            // const content = JSON.stringify(quill.getContents())
            post(`/adminsc/${this.model}/updateOrCreate`, this.dto())
         }.bind(this));
      }

      if (this.button) {
         this.button.addEventListener('click', function () {
               const productId = $(`.item-wrap[data-model='product']`)[0].dataset.id
               const txt = JSON.stringify(this.quill.getContents())
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


