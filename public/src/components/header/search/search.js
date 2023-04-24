import {$, debounce, post, createEl} from '../../../common'

export default class Search {
  constructor() {
    let button = $('.search').first();
    let panel = $('.search-panel').first();
    if (!button || !panel) return;
    this.button = button;
    this.panel = panel;
    this.text = $(panel).find('.text');
    this.result = $(panel).find('.result');

    this.button.onclick = this.showPanel.bind(this);

    this.debouncedKeyUp = debounce(this.find, 800);
    this.text.onkeyup = this.debouncedKeyUp.bind(this)
  }

  showPanel() {
    this.panel.classList.toggle('show')
  }

  async find({target}) {
    this.result.innerHTML = '';

    let text = this.text.innerText;
    let res = await post('/search', {text});
    if (res?.arr?.found) {
      this.makeString(res?.arr?.found)
    }
  }

  makeString(arr){
    let str = '';
    arr.map((row,i)=>{
      this.result.append(this.createLi(++i,row))
    })
  }

  createLi(i,row){
    let li = createEl('li');
    let a = createEl('a');
    a.href = `/product/${row.slug}`;
    let index = createEl('div', 'index', i);
    let name = createEl('div', 'name', row.name);
    let img = createEl('img');
    img.src = row.mainImagePath;
    a.append(index);
    a.append(name);
    a.append(img);
    li.append(a);
    return li
  }


}