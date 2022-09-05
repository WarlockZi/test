import './catalog-item.scss';
import {$, post, trimStr} from '../../common';
import WDSSelect from "../select/WDSSelect";

export default function catalogItem() {
  let customCatalogItem = $('.item_wrap')[0]
  if (customCatalogItem) {
    $(customCatalogItem).on('click', handleClick)
    let selects = $('[custom-select]')
    if (selects) {
      [].map.call(selects, function (select) {
        new WDSSelect(select)
      })
    }

  }

  async function handleClick({target}) {

    let item = customCatalogItem
    let modelName = item.dataset.model
    if (target.closest('.save')) {
      save(modelName)
    } else if (target.closest('.del')
      && target.closest('.del').dataset.model) {
      del(item, target.closest('.del').dataset.model)
    } else if ((target.classList.contains('tab'))) {
      handleTab(target, modelName)
    }
  }

  async function handleTab(target) {
    let visibleSection = $(`[data-tab].show`)[0]
    visibleSection.classList.toggle('show')
    let section = $(`[data-tab='${target.dataset.tabId}']`)[0]
    section.classList.toggle('show')

    let activeTab = $(`.tab.active`)[0]
    activeTab.classList.toggle('active')
    target.classList.toggle('active')
  }

  async function del(item, modelName) {
    let id = item.dataset.id
    let res = await post(`/adminsc/${modelName}/delete`, {id})
    if (res) {
      window.location.href = `/adminsc/${modelName}/edit`
    }
  }

  async function save(modelName) {
    if (checkRequired()) return false
    let model = getModel(modelName)
    let res = await post(`/adminsc/${modelName}/updateorcreate`, model)
  }

  function checkRequired() {
    let required = $('[required]');
    let errCount = 0;
    [].forEach.call(required, function (el) {
      if (!el.innerText) {
        el.style.borderColor = 'red'
        if ($(el).find('.error')) return
        let error = document.createElement('div')
        error.innerText = 'Заполните поле'
        error.classList.add('error')
        el.closest('.value').appendChild(error)
        errCount++
      }
    })
    return errCount
  }

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
          obj[field.dataset.field] = getInputs(field)
        } else if (field.type === 'date') {
          obj[field.dataset.field] = field.value
        } else {
          obj[field.dataset.field] = trimStr(field.innerText)
        }
      }
      ,
      obj
    )
    let isTest = $('[data-isTest]')[0]
    if (isTest) {
      obj.isTest = +isTest.dataset.istest
    }
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
    return names.join(',')

  }
}
