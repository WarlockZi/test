import './product.scss'
import {$, post, popup} from '../../common'
import {dnd, dnd1} from '../../components/dnd/dnd'

export default function product() {

  let product = $(`.item_wrap[data-model='product']`)[0]
  if (!product) return false

  let productId = $('.item_wrap')[0].dataset.id

//// description set tiny

  // // let form = $('#mytextarea')[0]
  //
  // let dtxt = $('.dtxt')[0]
  // let text = dtxt.innerHTML
  // // tinymce.get('mytextarea').setContent(text)
  // tinymce.activeEditor.setContent(text)
  // dtxt.remove()

  let form = $('#producttiny')[0]
  form.onsubmit = function () {
    tinymce.activeEditor.setProgressState(true)
    tinymce.triggerSave();
    setTimeout(async () => {
      let description = tinymce.activeEditor.getContent();
      let res = await post('/adminsc/product/adddescription',
        {
          description,
          'id':productId
        })
      if (res) {
        tinymce.activeEditor.setProgressState(false, 1000);
      }
    }, 1000);
  }



//// Property set
  let property = $(`[data-model='product'] [custom-select][data-model="property"]`)
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

/// Image delete
  let images = $('.images');
  [].forEach.call(images, function (i) {
    $(i).on('click', async function ({target}) {
      if (target.classList.contains('del')) {
        let img = target.closest('.image').querySelector('img')
        let del = target.closest('.image').querySelector('.del')
        let id = target.dataset.id
        let tag = target.dataset.tag
        let res = await post('/adminsc/product/' + tag, {productId, id})
        if (res.popup === 'ok') {
          img.remove()
          del.remove()
        }
      }
    })
  })

///// images set
  async function sendToServer(i, file, url) {
    let formData = new FormData()
    formData.append(i, file, file['name'])
    formData.append('imageable_id', productId)
    let res = await fetch(url, {
      method: 'POST',
      body: formData
    })
    let json = await res.json()
    let id = await json.arr.id
    if (json.arr.popup) {
      popup.show(json.arr.popup)
    }
    return id
  }

  function previewfile(file, appendTo, id, tag) {
    let reader = new FileReader();
    reader.readAsDataURL(file)
    reader.onload = function ({target}) {

      let image = new Image()
      image.src = target.result
      let im = document.createElement('div')
      let del = document.createElement('div')
      del.classList.add('del')
      del.dataset.id = id
      del.dataset.tag = tag
      del.innerText = 'x'
      im.classList.add('image')
      im.appendChild(image)
      im.appendChild(del)
      appendTo.appendChild(im)

    }.bind()
  }

  async function handleMainImage(appendTo, url, tag, files) {
    let id = await sendToServer(0, files[0], url)
    if (id) {
      appendTo.querySelector('.image').remove()
      // appendTo.querySelector('.del').remove()
      previewfile(files[0], appendTo, id, tag)
    }
  }

  async function handleMultipleImages(appendTo, url, tag, files) {
    for (let i = 0; i <= files.length - 1; i++) {
      if (!validateType(files[i])) {
        continue
      }
      let id = await sendToServer(i, files[i], url)
      if (id) {
        previewfile(files[i], appendTo, id, tag)
      }
    }
  }

  let appendTo = $('.image_main .images')[0]
  let url = '/adminsc/product/addMainImage'
  let tag = `delMainImage`
  dnd1('.add_main_image',
    handleMainImage.bind(null, appendTo, url, tag)
  )

  appendTo = $('.detail_images .images')[0]
  url = `/adminsc/product/addDetailImages`;
  tag = `delDetailImage`;
  dnd1('.add_detail_image',
    handleMultipleImages.bind(null, appendTo, url, tag)
  )

  appendTo = $('.small_pack_images .images')[0]
  url = `/adminsc/product/addSmallPackImage`;
  tag = `delSmallPackImages`;
  dnd1('.add_small_pack_images',
    handleMultipleImages.bind(null, appendTo, url, tag)
  )

  appendTo = $('.big_pack_images .images')[0]
  url = `/adminsc/product/addBigPackImage`;
  tag = `delBigPackImages`;
  dnd1('.add_big_pack_image',
    handleMultipleImages.bind(null, appendTo, url, tag)
  )


  function validateType(file) {
    if ([
      'image/png',
      'image/jpeg',
      'image/jpg',
      'image/webp',
      'image/gif'
    ].includes(file.type)) return true
    popup.show(`Тип файлa ${file['name']} должен быть jpg, jpeg, png, webp, gif`)
    return false
  }

}