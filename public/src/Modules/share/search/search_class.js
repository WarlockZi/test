import "./search.scss";
import { $, createEl, debounce, post } from "@src/common.js";
import { ael } from "@src/constants.js";

export default class Search_class {
  constructor(admin = false, openBtnSelector) {
    this.admin = admin;
    this.openBtnSelector = ".utils .search";
    this.queryInputSelector = ".text";

    const openBtn = $(this.openBtnSelector).first();
    const panel = $(".search-panel").first();

    if (!openBtn || !panel) return;

    this.openBtn = openBtn;
    this.panel = panel;

    this.queryInput = $(panel).find(this.queryInputSelector);
    this.result = $(panel).find(".result");
    this.closeBtn = $(panel).find(".close");

    this.debouncedKeyUp = debounce(this.find, 800);

    this.queryInput[ael]("keyup", this.debouncedKeyUp.bind(this));
    this.openBtn[ael]("click", this.openPanel.bind(this));
    document.body[ael]("click", this.closePanel.bind(this));
  }

  openPanel() {
    if (window.ym !== undefined) {
      YM("click_search");
    }
    this.panel.classList.add("show");
  }
  closePanel({ target }) {
    if (
      target.closest(this.openBtnSelector) === this.openBtn ||
      target.closest(this.queryInputSelector) === this.queryInput
    )
      return false;
    this.panel.classList.remove("show");
    this.result.innerHTML = "";
    this.queryInput.value = "";
  }

  async find({ target }) {
    this.result.innerHTML = "";

    const text = target.value;
    if (!text) return false;
    const res = await post("/search", { text });
    if (res?.found) {
      this.result.style.display = "initial";
      res?.found.map((row) => {
        this.result.append(this.createLi(row));
      });
    }
  }

  createLi(row) {
    const a = createEl("a");
    a.href = this.admin
      ? `/adminsc/product/edit/${row.id}`
      : `/product/${row?.slug}`;
    if (row?.deleted_at) {
      a.classList.add("deleted");
    }
    const li = createEl("li");
    li.appendChild(a);
    const name = createEl("div", "name", row.name || "Без названия");
    const art = createEl("div", "art", row?.art || "-");

    const img = createEl("img");
    const notFound = "/storage/app/srvc/nophoto.png";
    img.src = row?.mainImage || notFound;
    img.onerror = function () {
      this.src = notFound;
    };
    a.append(art, name, img);
    li.append(a);
    return li;
  }
}
