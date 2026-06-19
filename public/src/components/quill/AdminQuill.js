import { debounce, isJson, post } from "@src/common.js";
import Quill from "quill";
import { ael } from "@src/constants.js";
import RelationDTO from "@src/Admin/DTO/RelationDTO.js";
import FieldDTO from "@src/Admin/DTO/FieldDTO.js";

export default class AdminQuill {
  constructor(el, options = {}) {
    if (!el) return;
    this.el = el;

    this.autosave = options?.autosave || true;
    this.editable = options?.editable || true;

    this.options = this.setOptions();
    this.quill = new Quill(el, this.options);
    this.dto = new FieldDTO(this.el);
    this.setContent();

    if (this.autosave) this.el[ael]("keyup", debounce(this.save.bind(this)));
  }

  async save() {
    this.dto.relation.field[this.el?.dataset?.field] = JSON.stringify(
      this.quill.getContents(),
    );
    const res = await post(
      `/adminsc/${this.dto.model}/updateOrCreate`,
      this.dto,
    );
  }

  setContent() {
    if (isJson(this.el.innerText)) {
      this.quill.setContents(JSON.parse(this.el.innerText + "\n"));
    } else {
      const cleanText = this.el.innerText.replace(/\n\n/gi, "\n"); // Заменяем <br> на переносы строки
      // const cleanText = this.el.innerText.replace(/<br\s*\/?>/gi, ""); // Заменяем <br> на переносы строки
      this.quill.setText(cleanText);
    }
  }

  setToolbar() {
    return [
      [{ header: [2, 3, 4, false] }],
      ["bold", "italic", "underline", "strike"], // toggled buttons
      // ['blockquote'],

      // [{ 'header': 1 }, { 'header': 2 }],               // custom button values
      [{ list: "ordered" }, { list: "bullet" }],
      [{ script: "sub" }, { script: "super" }], // superscript/subscript
      [{ indent: "-1" }, { indent: "+1" }], // outdent/indent
      // [{ 'direction': 'rtl' }],                         // text direction

      [{ size: ["small", false, "large", "huge"] }], // custom dropdown

      [{ color: [] }, { background: [] }], // dropdown with defaults from theme
      [{ font: [] }],
      [{ align: [] }],

      ["clean"], // remove formatting button
    ];
  }

  setOptions(options) {
    return {
      theme: options?.theme || "snow", /// || "bubble";
      placeholder: options?.placeholder || "Начните писать...",
      modules: {
        toolbar: this.setToolbar(),
      },
    };
  }
}
