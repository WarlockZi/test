import "./search.scss";
import {$, debounce, post, createEl} from '../../../common'

export default class Search {

  constructor() {

    debugger;
    let button = $('.search').first();
    let panel = $('.search-panel').first();
    if (!button || !panel) return;
    this.button = button;
    this.panel = panel;
    this.text = $(panel).find('.text');
    this.result = $(panel).find('.result');

    this.button.onclick = this.showPanel.bind(this);
    this.panel.onclick = this.closePanel.bind(this);

    this.debouncedKeyUp = debounce(this.find, 800);
    this.text.onkeyup = this.debouncedKeyUp.bind(this)
  }

  showPanel() {
    this.panel.classList.toggle('show');
    this.result.innerHTML = '';
    this.text.value = ''
  }

  closePanel({target}) {
    if (!target.classList.contains('search-panel')) return false;
    this.panel.classList.toggle('show');
    this.result.innerHTML = '';
    this.text.value = ''
  }
  
  async find({target}) {
    this.result.innerHTML = '';

    let text = target.value;
    if (!text) return false;
    let res = await post('/search', {text});
    if (res?.arr?.found) {
      this.makeString(res?.arr?.found)
    }
  }

  makeString(arr){
    arr.map((row)=>{
      this.result.append(this.createLi(row))
    })
  }

  createLi(row){
    let li = createEl('li');
    let a = createEl('a');
    a.href = `/product/${row.slug}`;
    li.append(a);
    let name = createEl('div', 'name', row.name);
    let art = createEl('div', 'art', row.art);
    let img = createEl('img');
    img.src = row.mainImagePath;
    a.append(art);
    a.append(name);
    a.append(img);
    li.append(a);
    return li
  }


}