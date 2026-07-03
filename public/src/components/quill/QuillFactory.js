import AdminQuill from "@components/quill/AdminQuill.js";
import MyQuill from "@components/quill/MyQuill.js";

export default class QuillFactory {
  constructor(el) {
    if (!el) return false;
    this.el = el;
    this.create();
  }

  create() {
    if (this.el?.dataset.quill === "admin") {
      new AdminQuill(this.el);
    } else {
      new MyQuill(this.el);
    }
  }
}
