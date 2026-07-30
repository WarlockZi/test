import "./sync1c.scss";

import { $, post } from "@src/common.js";

export default class sync {
  constructor() {
    this.$sync = $(".sync").first();
    this.$log_content = $(this.$sync).find("#log_content");
    this.$sync.onclick = this.handleClick.bind(this);
  }

  async handleClick({ target }) {
    if (target.classList.contains("button")) {
      const res = await post(`/adminsc/sync/${target.id}`);

      if (res?.success) {
        this.$log_content.innerText = res.content;
      }
    }
  }
}
