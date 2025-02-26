import {$, debounce, IsJson, post} from "@src/common.js";
import DTO from "@src/Admin/DTO.js";
import Quill from "quill";
import {ael} from "@src/constants.js";

export default class AdminQuill {
   constructor(selector, options) {
      const el = $(selector).first()
      if (!el) return
      this.el = el
      this.autosave = options?.autosave || true
      this.editable = options?.editable || true
      this.theme = options?.theme || 'snow'
      this.placeholder = options?.theme || 'Начните писать...'

      this.options = this.setOptions()
      this.quill = new Quill(selector, this.options);
      this.dto = this.setDTO()
      this.setContent()
      if (this.autosave) this.el[ael]('keyup', debounce(this.save.bind(this)))
   }

   async save() {
      this.dto.relation.fields[this.el?.dataset?.field]
         = JSON.stringify(this.quill.getContents())
      const res = await post(`/adminsc/${this.dto.model}/updateOrCreate`, this.dto)
   }

   setContent() {
      if (IsJson(this.el.innerText)) {
         this.quill.setContents(JSON.parse(this.el.innerText + '\n'))
      } else {
         this.quill.setText(this.el.innerText)
      }
   }


   setDTO() {
      const parent = this.el.closest(`[data-model]`)
      const model = parent?.dataset.model
      const id = parent.dataset.id
      const dto = new DTO(id)
      dto.model = model
      dto.relation.name = this.el.dataset.relation
      return dto
   }

   setToolbar() {
      return [
         [{ 'header': [2, 3, 4, false] }],
         ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
         // ['blockquote'],

         // [{ 'header': 1 }, { 'header': 2 }],               // custom button values
         [{'list': 'ordered'}, {'list': 'bullet'}],
         [{'script': 'sub'}, {'script': 'super'}],      // superscript/subscript
         [{'indent': '-1'}, {'indent': '+1'}],          // outdent/indent
         // [{ 'direction': 'rtl' }],                         // text direction

         [{'size': ['small', false, 'large', 'huge']}],  // custom dropdown

         [{'color': []}, {'background': []}],          // dropdown with defaults from theme
         [{'font': []}],
         [{'align': []}],

         ['clean']                                         // remove formatting button
      ];
   }

   setOptions() {
      return {
         theme: this.theme,
         // theme: 'bubble',
         placeholder: this.placeholder,
         modules: {
            toolbar: this.setToolbar()
         },
      };
   }
}