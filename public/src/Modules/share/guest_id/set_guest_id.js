import { getCsrf } from "@src/common.js";

export default class set_guest_id {
  constructor() {
    if (localStorage.getItem("vitex_guest_id")) {
      const php_sess = getCsrf();
    }
  }
}
