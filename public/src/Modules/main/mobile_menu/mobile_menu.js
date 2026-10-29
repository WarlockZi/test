export default class Mobile_menu {
  constructor(HTMLElement) {
    this.navExpand = [].slice.call(document.querySelectorAll(".nav-expand"));
    if (!this.navExpand) return;

    this.HTMLElement = HTMLElement;
    this.backLink = `<li class="nav-item">

	<div 
	class="nav-link nav-back-link" 

	>
	<span class="chevron-left">
	<svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#FFFFFF"><path d="M522-480 333-669l51-51 240 240-240 240-51-51 189-189Z"/></svg>
	</span>
		Назад
	</div>
</li>`;

    this.navExpand.forEach((item) => {
      item
        .querySelector(".nav-expand-content")
        .insertAdjacentHTML("afterbegin", this.backLink);
      item
        .querySelector(".nav-link")
        .addEventListener("click", () => item.classList.add("active"));
      item
        .querySelector(".nav-back-link")
        .addEventListener("click", () => item.classList.remove("active"));
    });

    this.HTMLElement.addEventListener("click", this.open.bind(this));
  }
  open() {
    document.body.classList.toggle("nav-is-toggled");
  }
}
