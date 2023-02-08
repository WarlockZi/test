import './catalog-item.scss';
import {$, debounce, popup, post, trimStr} from '../../common';
import WDSSelect from "../select/WDSSelect";
import checkboxes from "../checkboxes/checkboxes";
import checkbox from "../checkbox/checkbox";
import DragNDrop from "../dnd/DragNDrop";

export default function catalogItem() {
  let customCatalogItem = $('.item_wrap')[0]
  if (customCatalogItem) {
    let selects = $('[custom-select]')

    if (selects) {
      [].map.call(selects, function (select) {
        new WDSSelect(select)
      })
    }
    let context = {
      model: customCatalogItem.dataset.model,
      id: +customCatalogItem.dataset.id
    }
    checkboxes('[checkboxes]',context)
      .onChange(update)
    // debugger
    checkbox(context);

    [].map.call($('[data-dnd]'), (dnd)=>{
      let dn = new DragNDrop(dnd, handleDnd)
    })

    customCatalogItem.onclick = handleClick.bind(context)
    customCatalogItem.onkeyup = debounce(handleKeyup.bind(context))
  }

  function handleDnd(files,target){
      debugger
    if (target.dataset.morph){

    } else if(target.dataset.belongsTo){

    }
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
      detach(this.id, this.model)
    } else if ((target.classList.contains('tab'))) {
      handleTab(target, this.model)
    } else if ((target.getAttribute('type')==='checkbox')) {
      // debugger
      // handleCheckbox.apply(this)
    }
  }

//   async function handleCheckbox() {
// debugger
//     this.target.classList.toggle('checked')
//     let field = this.target.dataset.field
//     let value = +target.classList.contains('checked')
//     let data = {id:this.id,[field]: value}
//     let res = await post(`/adminsc/${modelName}/updateOrCreate`, data)
//   }

  async function handleTab(target) {
    let visibleSection = $(`[data-tab].show`)[0]
    let section = $(`[data-tab='${target.dataset.tabId}']`)[0]
    let activeTab = $(`.tab.active`)[0]
    visibleSection.classList.toggle('show')
    section.classList.toggle('show')
    activeTab.classList.toggle('active')
    target.classList.toggle('active')
  }

  async function del(id, modelName) {
    let res = await post(`/adminsc/${modelName}/delete`, {id})
    if (res) {
      window.location.href = `/adminsc/${modelName}/edit`
    }
  }
  async function detach(id, modelName) {
    let res = await post(`/adminsc/${modelName}/detach`, {id})
    if (res) {
      window.location.href = `/adminsc/${modelName}/edit`
    }
  }

  async function update() {
    debugger
    let res = await post(`/adminsc/${this.model}/updateorcreate`, this.data)
  }

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

  function getModel(modelName) {
    let fields = $(`[data-field][data-model='${modelName}']`);
    let obj = {};

    // debugger;
    [].map.call(fields, (field) => {
        if (field.closest('[data-parent]')) return obj
        if (
          field.hasAttribute('data-value') ||
          field.hasAttribute('custom-select') ||
          field.hasAttribute('custom-radio') ||
          field.hasAttribute('tab')
        ) {
          obj[field.dataset.field] = field.dataset.value
        } else if (field.hasAttribute('multi-select')) {
          let chips = field.querySelectorAll('.chip');
          let ids = [].map.call(chips, (chip) => {
            return chip.dataset.id
          })
          obj[field.dataset.field] = ids.toString()
        } else if (field.dataset.type === 'inputs') {
          // debugger
          obj[field.dataset.field] = getInputs(field)
        } else if (field.type === 'date') {
          obj[field.dataset.field] = field.value ? field.value : '1970-01-02'
        } else {
          obj[field.dataset.field] = trimStr(field.innerText)
        }
      }
      ,
      obj
    )
    return obj
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
}
