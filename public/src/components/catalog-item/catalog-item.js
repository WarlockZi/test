import './catalog-item.scss';
import {$, post, popup} from '../../common';

export default function catalogItem() {
  let customCatalogItem = $('.custom-catalog-item__wrapper')[0]
  if (customCatalogItem) {
    $(customCatalogItem).on('click', handleClick)
  }

  function handleClick({target}) {
    if (target.closest('.save')) {
  debugger;
      let select = $(target)
      let modelName = $(customCatalogItem)
        .find('.custom-catalog-item')
        .dataset.model
      let model = getModel()
      let res = post(`/adminsc/${modelName}/updateorcreate`, {model})
      res = JSON.parse(res)
      if (res.mes ==='ok') {
        let i = 1
      }
    }
  }

  function getModel() {

  }

}
