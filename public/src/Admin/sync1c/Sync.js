import {$, popup, post} from "../../common";

export class Sync {
  constructor($sync) {
    this.$sync = $sync;
    this.$log_content = $($sync).find('#log_content');
    this.$sync.onclick = this.handleClick.bind(this)
  }

  async handleClick({target}) {
    if (target.classList.contains('button')) {
      let res = await post(`/adminsc/sync/${target.id}`);
      if (res?.arr?.success) {
        this.$log_content.innerText = res.arr?.content
      }
    } else {
    }
  }



}
