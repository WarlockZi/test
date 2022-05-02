import './catalog-item.scss';
import {$, post, popup} from '../../common';

export default function catalogItem() {
  let customCatalogItem = $('.custom-catalog-item__wrapper')[0]
  if (customCatalogItem) {
    $(customCatalogItem).on('click', handleClick)
  }

  async function handleClick({target}) {
    let item = $(customCatalogItem).find('.custom-catalog-item')
    let modelName = item.dataset.model
    if (target.closest('.save')) {
      let model = getModel()
      let res = await post(`/adminsc/${modelName}/update`, {...model})
      res = JSON.parse(res)
      if (res.msg === 'ok') {
        popup.show('Сохранено')
      }else if(res.error){
        popup.show(res.error)
      }
    } else if (target.closest('.del')) {
      let id = item.dataset.id
      let res = await post(`/adminsc/${modelName}/delete`, {id})
      res = JSON.parse(res)
      if (res.msg === 'ok') {
        window.location.href = `/adminsc/${modelName}/list`
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
      } else if (field.classList.contains('custom-select')){
        obj[field.dataset.field] = field.dataset.value
      } else if (field.hasAttribute('custom-radio')){
        obj[field.dataset.field] = field.dataset.value
      } else if (field.hasAttribute('tab')){
        obj[field.dataset.field] = field.dataset.value
      }else {
        obj[field.dataset.field] = field.innerText
      }
    }, obj)
    return obj
  }
}
