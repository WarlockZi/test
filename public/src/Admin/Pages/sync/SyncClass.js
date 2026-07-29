import { $, post } from "../../../common.js";

export class SyncClass {
  constructor($sync) {
    this.$sync = $sync;
    this.$log_content = $($sync).find("#log_content");
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
