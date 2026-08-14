import { getCookie, getPhpSession, setCookie } from "@src/common.js";

export default async function setLocalStorageCartId() {
  if (localStorage.getItem("vitex_guest_id")) {
    localStorage.setItem("vitex_guest_id", "vitex_guest_id_" + getPhpSession());
  }
}
