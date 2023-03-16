import './catalog-item.scss';
import {$, debounce, post, trimStr,formatDate} from '../../common';
import checkboxes from "../checkboxes/checkboxes";
import checkbox from "../checkbox/checkbox";


export default function catalogItem() {

  // self = new this
  let customCatalogItem = $('.item_wrap')[0]
  if (customCatalogItem) {

    self.model = customCatalogItem.dataset.model
    self.id = +customCatalogItem.dataset.id

    let context = {
      model: customCatalogItem.dataset.model,
      id: +customCatalogItem.dataset.id
    }

    checkboxes('[checkboxes]', context)
      .onChange(update)
    checkbox(context);

    customCatalogItem.onclick = handleClick.bind(context)
    customCatalogItem.onkeyup = debounce(handleKeyup.bind(context))
  }

  async function handleKeyup({target}) {
    if (
      !target.hasAttribute('contenteditable') ||
      !target.dataset.field
    ) return

    let field = target.dataset.field
    let data = {
      id: this.id,
      [field]: target.innerText
    }
    await post(`/adminsc/${this.model}/updateOrCreate`, data)
  }


  async function handleClick({target}) {

    this.target = target
    if (target.closest('.save')) {
      // save.bind(this)
    } else if (target.closest('.detach')) {
      // detach(this.id, this.model)
    } else if (target.hasAttribute('soft-del')) {
      softDel(this)
    } else if ((target.classList.contains('tab'))) {
      handleTab(target, this.model)
    } else if ((target.getAttribute('type') === 'checkbox')) {
      // debugger
      // handleCheckbox.apply(this)
    }
  }

  async function handleTab(target) {
    let visibleSection = $(`[data-tab].show`)[0]
    let section = $(`[data-tab='${target.dataset.tabId}']`)[0]
    let activeTab = $(`.tab.active`)[0]
    visibleSection.classList.toggle('show')
    section.classList.toggle('show')
    activeTab.classList.toggle('active')
    target.classList.toggle('active')
  }

  async function softDel(self) {
    let url = `/adminsc/${self.model}/updateorcreate`

    let deleted = new Date().toLocaleString('ru-RU', {year: 'numeric', month: '2-digit', day: '2-digit', hour: '2-digit', hour12: false, minute:'2-digit'})
    debugger
    let data = {deleted_at: deleted, id: self.id}
    let res = await post(url, data)

    if (res) {
      console.log('lk------')
    }

  }


  async function update() {
    let res = await post(`/adminsc/${this.model}/updateorcreate`, this.data)
  }


  function getInputs(field) {
    let inputs = field.querySelectorAll('input')
    let names = []
    inputs.forEach((inp) => {
      if (!inp.checked) return
      let name = inp.parentNode.querySelector('.name').innerText
      if (!name) return

      names.push(name)
    })
    return names.join()
  }

  // function getModel(modelName) {
  //   let fields = $(`[data-field][data-model='${modelName}']`);
  //   let obj = {};
  //
  //   debugger;
  //   [].map.call(fields, (field) => {
  //       if (field.closest('[data-parent]')) return obj
  //       if (
  //         field.hasAttribute('data-value') ||
  //         field.hasAttribute('custom-select') ||
  //         field.hasAttribute('custom-radio') ||
  //         field.hasAttribute('tab')
  //       ) {
  //         obj[field.dataset.field] = field.dataset.value
  //       } else if (field.hasAttribute('multi-select')) {
  //         let chips = field.querySelectorAll('.chip');
  //         let ids = [].map.call(chips, (chip) => {
  //           return chip.dataset.id
  //         })
  //         obj[field.dataset.field] = ids.toString()
  //       } else if (field.dataset.type === 'inputs') {
  //         // debugger
  //         obj[field.dataset.field] = getInputs(field)
  //       } else if (field.type === 'date') {
  //         obj[field.dataset.field] = field.value ? field.value : '1970-01-02'
  //       } else {
  //         obj[field.dataset.field] = trimStr(field.innerText)
  //       }
  //     },
  //     obj
  //   )
  //   return obj
  // }
  // function checkRequired() {
  //   let required = $('[required]');
  //   let errCount = 0;
  //   [].forEach.call(required, function (el) {
  //     if (!el.innerText) {
  //       el.style.borderColor = 'red'
  //       if ($(el).find('.error')) return
  //       let error = document.createElement('div')
  //       error.innerText = 'Заполните поле'
  //       error.classList.add('error')
  //       el.closest('.value').appendChild(error)
  //       errCount++
  //     }
  //   })
  //   return errCount
  // }
  // async function sendToServer(i, file, url) {
  //   let formData = new FormData()
  //   formData.append(i, file, file['name'])
  //   formData.append('imageable_id', productId)
  //   let res = await fetch(url, {
  //     method: 'POST',
  //     body: formData
  //   })
  //   let json = await res.json()
  //   let id = await json.arr.id
  //   if (json.arr.popup) {
  //     popup.show(json.arr.popup)
  //   }
  //   return id
  // }


  // async function del(id, modelName) {
  //   let res = await post(`/adminsc/${modelName}/delete`, {id})
  //   if (res) {
  //     window.location.href = `/adminsc/${modelName}/edit`
  //   }
  // }
  //
  // async function detach(id, modelName) {
  //   debugger
  //   let res = await post(`/adminsc/${modelName}/detach`, {id})
  //   if (res) {
  //     window.location.href = `/adminsc/${modelName}/edit`
  //   }
  // }
  //
}
