import './product.scss'
import {$, post} from '../../common'
import {dnd} from '../../components/dnd/dnd'

export default function product() {
  let property = $(`[data-model='product'] [custom-select]`)
  if (property) {
    [].map.call(property, function (prop) {

      let observer = new MutationObserver(function (mutations) {
        mutations.forEach(function (mutation) {
          let propertable_id = $('.item_wrap')[0].dataset.id
          let property_id = mutation.target.dataset.modelId
          let val_id = mutation.target.dataset.value
          post('/adminsc/product/setProperty',
            {propertable_id, property_id, val_id})

        });
      });

      observer.observe(
        prop, {attributes: true,}
      );
    })
  }


  let productId = $('.item_wrap')[0].dataset.id

  let images = $('.images');
  [].forEach.call(images, function (i) {
    $(i).on('click', async function ({target}) {
      if (target.classList.contains('del')) {
        let img = target.closest('.image').querySelector('img')
        let del = target.closest('.image').querySelector('.del')
        let id = target.dataset.id
        let tag = target.dataset.tag
        let res = await post('/adminsc/product/'+tag, {productId,id})
        if (res.popup==='ok'){
          img.remove()
          del.remove()
        }
      }
    })
  })

  // function mainImageCallBack(){
  //   if (replace) {
  //     if (appendTo.querySelector('img')) {
  //       appendTo.querySelector('img').remove()
  //     }
  //   }
  //   let image = new Image()
  //   image.src = target.result
  //
  //   appendTo.appendChild(image)
  // }



  dnd('.add_main_image',
    '/adminsc/product/imageMain',
    productId,
    '.image_main .images .image',
    true
  )

  dnd('.add_detail_image',
    '/adminsc/product/imageDetail',
    productId,
    '.detail_images .images',
    false
  )

}