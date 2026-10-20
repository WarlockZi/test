import { $ } from "@src/common.js";

export default function headerMenu(menu) {
  if (!menu) return false;

  $(menu).on("click", ".arrow", ({ target }) => {
    const ul = $(target.closest("li")).find("ul");
    ul.classList.toggle("visible");
  });
}
//TODO refactor file rename del duplicate
