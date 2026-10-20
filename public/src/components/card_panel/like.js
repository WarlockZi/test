import { post } from "../../common.js";

export default async function handleLike(target) {
  if (!target) return;

  const res = await post("/like/toggle", productDTO(target));
  target.dataset.like = "" + res?.liked;

  function productDTO(target) {
    return {
      product_1s_id:
        target.closest("[data-product_1s_id]")?.dataset.product_1s_id ?? null,
    };
  }
}
