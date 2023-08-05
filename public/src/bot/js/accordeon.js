export class Accordeon {
    constructor(accordeonSelector) {
        this.$accordeon = document.querySelector(accordeonSelector);

        if (!this.$accordeon) return;

        this.elementOld = null;
        this.openClass = "accordeon-item_open";
        this.contentClass = ".accordeon-item-content";

        this.$accordeon.addEventListener("click", this.toggleAccordion.bind(this))
    }

    toggleAccordion({ target }) {

        let element = target.closest(".accordeon-item");

        if (!element) return;

        let content = element.querySelector(this.contentClass);

        if (this.elementOld != null) {
            this.elementOld.classList.remove(this.openClass);
            let contentOld = this.elementOld.querySelector(this.contentClass);
            contentOld.style.maxHeight = "0px";
        }

        if (this.elementOld !== element) {
            element.classList.add(this.openClass);
            content.style.maxHeight = content.scrollHeight + "px";
            this.elementOld = element;
        } else {
            this.elementOld = null;
        }
    }

}