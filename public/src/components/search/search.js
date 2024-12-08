import "./search.scss";
import {$, createEl, debounce, post} from '../../common.js'
import {ael} from "../../constants.js";

export default class Search {

   constructor(admin = false) {

      this.admin = admin;
      const openBtn = $('.utils .search').first();
      const panel = $('.search-panel').first();

      if (!openBtn || !panel) return;
      this.openBtn = openBtn;
      this.panel = panel;

      this.text = $(panel).find('.text');
      this.result = $(panel).find('.result');
      this.closeBtn = $(panel).find('.close');

      this.debouncedKeyUp = debounce(this.find, 800);

      this.text[ael]('keyup', this.debouncedKeyUp.bind(this))
      this.openBtn[ael]('click', this.togglePanel.bind(this))
      this.closeBtn[ael]('click', this.togglePanel.bind(this))
   }

   togglePanel() {
      YM('click_search')
      this.panel.classList.toggle('show');
      this.result.innerHTML = '';
      this.text.value = ''
   }

   async find({target}) {
      this.result.innerHTML = '';

      const text = target.value;
      if (!text) return false;
      const res = await post('/search', {text});
      if (res?.arr?.found) {
         this.result.style.display = 'initial';
         res?.arr?.found.map((row) => {
            this.result.append(this.createLi(row))
         })
      }
   }

   createLi(row) {
      const li = createEl('li');

      const a = createEl('a');
      a.href = this.admin ? `/adminsc/product/edit/${row.id}` : `/product/${row.slug}`;
      if (row.deleted_at) {
         a.classList.add('deleted')
      }
      li.appendChild(a);
      const name = createEl('div', 'name', row.name);
      const art = createEl('div', 'art', row.art);
      const img = createEl('img');
      img.src = row.mainImage;
      a.append(art);
      a.append(name);
      a.append(img);
      li.append(a);
      return li
   }


}