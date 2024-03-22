export class Accordeon {
    constructor(accordeonSelector) {
        this.$accordeon = document.querySelector(accordeonSelector);

        if (!this.$accordeon) return;

        this.elementOld = null;
        this.element = null;
        this.content = null;
        this.icon = null;
        this.openClass = "accordeon-item_open";
        this.contentClass = ".accordeon-item-content";
        this.iconSelectror = ".accordeon-trigger";

        this.$accordeon.addEventListener("click", this.toggleAccordion.bind(this))
    }

    toggleAccordion({ target }) {

        this.element = target.closest(".accordeon-item");

        if (!this.element) return;

        let isContent = target.closest('.accordeon-item-content');
        if (isContent) return;

        this.content = this.element.querySelector(this.contentClass);
        this.icon = this.element.querySelector(this.iconSelectror);

        if (this.elementOld != null) {
            this.close()
        }

        if (this.elementOld !== this.element) {
            this.open()
        } else {
            this.elementOld = null;
        }
    }

    open(){
        this.element.classList.add(this.openClass);
        this.content.style.maxHeight = this.content.scrollHeight + "px";
        let oldIcon = this.$accordeon.querySelector('.rotate');
        if (oldIcon) oldIcon.classList.remove('rotate');
        this.elementOld = this.element;
        this.icon.classList.add('rotate')
    }

    close(){
        this.elementOld.classList.remove(this.openClass);
        let contentOld = this.elementOld.querySelector(this.contentClass);
        contentOld.style.maxHeight = "0px";
        this.icon.classList.remove('rotate')


    }

}