import './catalog-item.scss';
import {$, debounce, post, trimStr, formatDate, createEl} from '../../common';
import checkboxes from "../checkboxes/checkboxes";
import checkbox from "../checkbox/checkbox";



export default async function catalogItem() {

  let customCatalogItem = $('.item-wrap')[0];
  if (customCatalogItem) {

    self.model = customCatalogItem.dataset.model;
    self.id = +customCatalogItem.dataset.id;

    let context = {
      model: customCatalogItem.dataset.model,
      id: +customCatalogItem.dataset.id
    };

    checkboxes('[checkboxes]', context)
      .onChange(update);
    checkbox(context);

    customCatalogItem.onclick = handleClick.bind(context);
    customCatalogItem.onkeyup = debounce(handleKeyup.bind(context));

  }

  function showSavedFile(srcs) {
    debugger;
    srcs.relativeSrcs.forEach((src) => {
      let img = createEl('img');
      img.src = src;
      this.el.closest('.dnd-container').append(img)
    })

  }

  async function handleKeyup({target}) {
    if (
      !target.hasAttribute('contenteditable') ||
      !target.dataset.field
    ) return;

    let field = target.dataset.field;
    let data = {
      id: this.id,
      [field]: target.innerText
    };
    await post(`/adminsc/${this.model}/updateOrCreate`, data)
  }


  async function handleClick({target}) {

    this.target = target;
    if (target.closest('.save')) {
      // save.bind(this)
    } else if (target.closest('.detach')) {
      // detach(this.id, this.model)
    } else if (target.hasAttribute('soft-del')) {
      softDel(this)
    } else if ((target.classList.contains('tab'))) {
      handleTab(target, this.model)
    } else if ((target.getAttribute('type') === 'checkbox')) {
    }
  }

  async function handleTab(target) {
    let visibleSection = $(`[data-tab].show`)[0];
    let section = $(`[data-tab='${target.dataset.tabId}']`)[0];
    let activeTab = $(`.tab.active`)[0];
    visibleSection.classList.toggle('show');
    section.classList.toggle('show');
    activeTab.classList.toggle('active');
    target.classList.toggle('active')
  }

  async function softDel(self) {
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

  async function update() {
    let res = await post(`/adminsc/${this.model}/updateorcreate`, this.data)
  }

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
