import './catalog-item.scss';
import {$, post, popup} from '../../common';

export default function catalogItem() {
  let customCatalogItem = $('.item_wrap')[0]
  if (customCatalogItem) {
    $(customCatalogItem).on('click', handleClick.bind(this))
  }

  function checkRequired() {
    let required = $('[required]');
    let errCount = 0;
    [].forEach.call(required, function (el) {
      if (!el.innerText){
        el.style.borderColor = 'red'
        if ($(el).find('.error'))return
        let error = document.createElement('div')
        error.innerText='Заполните поле'
        error.classList.add('error')
        el.closest('.value').appendChild(error)
        errCount++
      }
    })
    return errCount
  }
  async function handleClick({target}) {

    let item = customCatalogItem
    let modelName = item.dataset.model
    if (target.closest('.save')) {
      if (checkRequired()) return false
      let model = getModel()
      let res = await post(`/adminsc/${modelName}/updateorcreate`, {...model})
      res = JSON.parse(res)
      if (res.id) {
        // window.location = '/adminsc/opentest/edit'

        popup.show('Сохранено')
      }else if(res.error){
        popup.show(res.error)
      }
    } else if (target.closest('.del')) {
      let id = item.dataset.id
      let res = await post(`/adminsc/${modelName}/delete`, {id})
      res = JSON.parse(res)
      if (res.msg === 'ok') {
        window.location.href = `/adminsc/${modelName}`
      }
    }else if((target.classList.contains('tab'))){
      let visibleSection = $(`section.show`)[0]
      visibleSection.classList.toggle('show')
      let section = $(`section[data-id='${target.dataset.id}']`)[0]
      section.classList.toggle('show')
      let activeTab = $(`.tab.active`)[0]
      activeTab.classList.toggle('active')
      target.classList.toggle('active')
    }
  }

  function getModel() {
    let fields = $('[data-field]');
    let obj = {};
    // debugger;
    [].map.call(fields, (field) => {
      if (field.hasAttribute('multi-select')) {
        let chips = field.querySelectorAll('.chip');
        let ids = [].map.call(chips, (chip) => {
          return chip.dataset.id
        })
        obj[field.dataset.field] = ids.toString()
      } else if (field.hasAttribute('custom-select')){
        obj[field.dataset.field] = field.dataset.value
      } else if (field.hasAttribute('custom-radio')){
        obj[field.dataset.field] = field.dataset.value
      } else if (field.hasAttribute('tab')){
        obj[field.dataset.field] = field.dataset.value
      } else if (field.type === 'date'){
        obj[field.dataset.field] = field.value
      }else {
        obj[field.dataset.field] = field.innerText
      }
    }, obj)
    let isTest = $('[data-isTest]')[0]
    if (isTest){
      obj.isTest = +isTest.dataset.istest
    }
    return obj
  }
}
