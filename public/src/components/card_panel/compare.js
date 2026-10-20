import { popup, post } from "../../common.js";

export default async function handleCompare(target) {
  if (!target) return;

  const res = await post("/compare/toggle", productDTO(target));
  target.dataset.compare = "" + res?.compared;

  function productDTO(target) {
    return {
      product_1s_id:
        target.closest("[data-product_1s_id]")?.dataset.product_1s_id ?? null,
    };
  }
}
