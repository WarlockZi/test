import { qa, quillSelector } from "@src/constants.js";

export default class MyQuills {
  constructor() {
    this.quills = document[qa](quillSelector);
    this.init();
  }
  async init() {
    if (this.quills.length) {
      const { default: QuillFactory } =
        await import("@components/quill/QuillFactory.js");
      [].forEach.call(this.quills, (el) => {
        new QuillFactory(el);
      });
    }
  }
}
