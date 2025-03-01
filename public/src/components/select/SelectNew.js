import './selectNew.scss'

import {$, createElement} from "../../common";

export default class SelectNew {
   constructor(el) {
      if (!el | !$(el).find('option')) return;

      this.ul = (new createElement()).tag("ul").attr('class', "options").get();
      this.label = (new createElement()).tag("span").get();

      this.options = this.getFormattedOptions(el.querySelectorAll("option"));

      this.space = (new createElement()).tag("div").attr('class', "space").text(this?.selectedOption?.label).get();
      this.arrow = (new createElement()).tag("div").attr('class', "arrow").get();
      this.sel = this.createSelectTag(el)


      el.after(this.sel);
      this.label.append(this.space);
      this.label.append(this.arrow);
      this.sel.append(this.label);
      this.sel.append(this.ul);
      el.remove()

      this.ul.addEventListener('click', this.handleUlClick.bind(this));
      this.label.addEventListener('click', this.handleLabelClick.bind(this));
      this.sel.addEventListener('blur', this.handleSelectBlur.bind(this))
      this.sel.addEventListener('keydown', this.handleSelectKeydown.bind(this))

      return this;
   }

   getFormattedOptions(options) {
      return [...options].map(option => {
         const li = (new createElement()).tag("li").text(option.label).attr('data-value', option.value).get();
         if (option.selected) li.classList.add("selected");
         this.ul.append(li)

         return {
            value: option.value,
            label: option.label,
            selected: option.selected,
            element: li,
            option: option,
         }
      })
   }

   createSelectTag(el) {
      const selectTag = this.setSelectTag(el)
      if (el.hasAttribute('data-field')) selectTag.attr('data-field', el.dataset.field)
      if (el.hasAttribute('name')) selectTag.attr('name', el.name)
      if (el.hasAttribute('data-relation')) selectTag.attr('data-relation', el.dataset.relation)
      if (el.hasAttribute('data-pivot')) selectTag.attr('data-pivot', el.dataset.pivot)
      if (el.firstElementChild.hasAttribute('data-relation')) selectTag.attr('data-relation', el.firstChild.dataset.relation)
      if (el.firstElementChild.hasAttribute('data-relationmodel')) selectTag.attr('data-relationmodel', el.firstChild.dataset.relationmodel)

      return selectTag.get();
   }

   setSelectTag(el) {
      return (new createElement())
         .tag("div")
         .className(el?.className)
         .field(el.dataset.field)
         .attr("select-new", '')
         .attr("data-value", this?.selectedOption?.value ?? '')
         .attr('tabindex', '0')
   }

   handleSelectBlur() {
      this.ul.classList.remove("show");
   }

   handleLabelClick() {
      this.ul.classList.toggle("show");
   }

   handleUlClick({target}) {
      target.classList.add("selected")
      this.selectedOption.element.classList.remove("selected")

      this.selectValue(target.dataset.value);
      this.ul.classList.remove("show");
   }

   onchange(callback) {
      this.callback = callback
   }

   handleSelectKeydown(e) {
      let debounceTimeout;
      let searchTerm = "";

      if (e.code === "Space") {
         select.ul.classList.toggle("show");
      } else if (e.code === "ArrowUp") {
         const prevOption = select.options[select.selectedOptionIndex - 1];
         if (prevOption) {
            select.selectValue(prevOption.value)
         }
      } else if (e.code === "ArrowDown") {
         const nextOption = select.options[select.selectedOptionIndex + 1];
         if (nextOption) {
            select.selectValue(nextOption.value)
         }
      } else if (e.code === "Enter" || e.code === "Escape") {
         select.ul.classList.remove("show");
      } else {
         clearTimeout(debounceTimeout);
         searchTerm += e.key;
         debounceTimeout = setTimeout(() => {
            searchTerm = ""
         }, 500);
         const searchedOption = this.options.find(option => {
            return option.label.toLowerCase().includes(searchTerm)
         });
         if (searchedOption) {
            this.sel.selectValue(searchedOption.value)
         }
      }
   }

   get selectedOption() {
      return this.options.find(option => option.selected)
   }

   get selectedOptionIndex() {
      return this.options.indexOf(this.selectedOption)
   }

   selectValue(value) {
      const next = this.options.find(option => {
         return option.value === value
      });
      const prev = this.selectedOption;

      prev.selected = false;
      next.selected = true;

      this.space.innerText = next.label;

      this.sel.dataset['value'] = next.value;
      prev.element.classList.remove('selected');

      next.element.classList.add('selected');
      next.element.scrollIntoView({block: "nearest"});

      this.sel.dispatchEvent(new CustomEvent('customSelect.changed', {
         bubbles: true,
         detail: {next, prev, target: this.sel}
      }));
   }

   // setOption(option) {
   //    const li = (new createElement()).tag("li").text(option.label).attr('data-value', option.value).get();
   //
   //    if (option.selected) li.classList.add("selected");
   //    // li.onclick = ({target}) => {
   //    //   select.selectValue(option.value);
   //    //   select.ul.classList.remove("show");
   //    // };
   //    this.ul.append(li)
   // }
}