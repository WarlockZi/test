import { getPhpSession } from "@src/common.js";

export default async function setLocalStorageGuestId() {
  if (!localStorage.getItem("vitex_guest_id")) {
    localStorage.setItem("vitex_guest_id", getPhpSession());
  }
}
