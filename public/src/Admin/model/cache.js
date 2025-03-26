import { $, post } from "../../common";

export default function cache() {
  $(".clearCache").on("click", clear);

  async function clear() {
    const res = await post("/adminsc/clearCache", {});
  }
}
