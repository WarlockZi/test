import { Select } from "@components/select/Factory/Select.js";

export default class SearchableSelect extends Select {
  constructor(selectEl, config) {
    super(selectEl, config);
    this.search = true;
  }
  render() {
    super.render();
    this.elements.searchInput = document.createElement("input");
    this.elements.searchInput.type = "text";
    this.elements.searchInput.className = "fs-search";
    this.elements.searchInput.placeholder = "Поиск...";
    this.elements.searchInput.setAttribute("autocomplete", "off");

    this.elements.dropdown.prepend(this.elements.searchInput);
  }
  bindEvents() {
    super.bindEvents();
    this.elements.searchInput.addEventListener("input", () => this.filter());
    this.elements.searchInput.addEventListener("keydown", (e) => {
      if (e.key === "Escape") this.close();
    });
  }
  open() {
    super.open();
    this.elements.searchInput.value = "";
    this.filter();
    setTimeout(() => this.elements.searchInput.focus(), 1000);
  }

  filter() {
    const query = this.elements.searchInput.value.toLowerCase().trim();
    let visibleCount = 0;

    this.elements.optionElements.forEach((li) => {
      const match = li.textContent.toLowerCase().includes(query);
      // li.style.display = match ? "" : "none";
      li.classList.toggle("none", !match);
      if (match) visibleCount++;
    });

    this.elements.noResults.style.display =
      visibleCount === 0 ? "block" : "none";
    this.visibleOptions();
  }
  reset() {
    super.reset();
    this.elements.searchInput.value = "";
    this.filter();
  }
}
