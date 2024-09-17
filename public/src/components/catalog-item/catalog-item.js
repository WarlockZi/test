import './catalog-item.scss';
import {$, debounce, post} from '../../common';
import checkboxes from "../checkboxes/checkboxes";
import checkbox from "../checkbox/checkbox";


export default class CatalogItem {

   constructor(customCatalogItem) {
      if (!customCatalogItem) return false

      this.model = customCatalogItem.dataset.model;
      this.id = +customCatalogItem.dataset.id;

      checkboxes('[checkboxes]', this.dto())
         .onChange(this.update);
      checkbox(this.dto());

      customCatalogItem.onclick = this.handleClick.bind(this);
      customCatalogItem.onkeyup = debounce(this.handleKeyup.bind(this));
   }

   dto() {
      return {
         model: this.model,
         id: this.id,

      }
   }

   async handleKeyup({target}) {
      if (
         !target.hasAttribute('contenteditable') ||
         !target.dataset.field
      ) return false

      const field = target.dataset.field;
      const relation = target.dataset.relation
      const data = this.dto()
      data.relation = relation??null
      // data.where.field = where??null
      data.fields = {
         // id: this.id,
         [field]: target.innerText,
      }
      const res = await post(`/adminsc/${this.model}/updateOrCreate`, data)
      if (res) {
         target.dispatchEvent(new CustomEvent('catalogItem.changed', {
               bubbles: true,
               detail: {res}
            })
         )
      }
   }


   async handleClick({target}) {
      // this.target = target;
      if (target.closest('.save')) {
         // save.bind(this)
      } else if (target.closest('.detach')) {
         // detach(this.id, this.model)
      } else if (target.hasAttribute('soft-del')) {
         softDel(this)
      } else if ((target.classList.contains('tab'))) {
         this.handleTabClick(target)
      } else if ((target.getAttribute('type') === 'checkbox')) {
      }
   }

   handleTabClick(target) {
      const tabId = target.dataset.tabId
      $(`[data-tab].show`).first().classList.toggle('show');
      $(`[data-tab='${tabId}']`).first().classList.toggle('show');
      $(`.tab.active`).first().classList.toggle('active');
      target.classList.toggle('active')
   }

   async softDel(self) {
      let url = `/adminsc/${self.model}/updateorcreate`;

      let deleted = new Date().toLocaleString('ru-RU', {
         year: 'numeric',
         month: '2-digit',
         day: '2-digit',
         hour: '2-digit',
         hour12: false,
         minute: '2-digit'
      });
      debugger;
      let data = {deleted_at: deleted, id: self.id};
      let res = await post(url, data);

      if (res) {
         console.log('lk------')
      }

   }

   async update() {
      let res = await post(`/adminsc/${this.model}/updateorcreate`, this.data)
   }

   //  showSavedFile(srcs) {
   //   debugger;
   //   srcs.relativeSrcs.forEach((src) => {
   //     let img = createEl('img');
   //     img.src = src;
   //     this.el.closest('.dnd-container').append(img)
   //   })
   // }

   // function getInputs(field) {
   //   let inputs = field.querySelectorAll('input');
   //   let names = [];
   //   inputs.forEach((inp) => {
   //     if (!inp.checked) return;
   //     let name = inp.parentNode.querySelector('.name').innerText;
   //     if (!name) return;
   //
   //     names.push(name)
   //   });
   //   return names.join()
   // }

}
