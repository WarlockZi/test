import {$, post, objAndData2FormData} from "../../common";
import DragNDrop from "../dnd/DragNDrop";
import DragNDropMany from "../dnd/DragNDropMany";
import DragNDropOne from "../dnd/DragNDropOne";

export default class Morph {

  constructor(dnd, morphedEl) {
    ///image
    // debugger
    let morphEl = dnd.parentNode
    this.morphModel = morphEl.dataset.morphModel
    this.morphId = morphEl.dataset.morphId
    this.slug = morphEl.dataset.morphSlug ?? ''
    this.oneOrMany = morphEl.dataset.morphOneormany

    ///category
    this.morphedModel = morphedEl.dataset.model
    this.morphedId = morphedEl.dataset.id

    this.path = dnd.dataset.path ?? ''
    this.append = morphEl

    let dndCallback = Morph.dndCallback.bind(this)

    if (this.oneOrMany === 'many') {
      new DragNDropMany(dnd, dndCallback)
    } else {
      new DragNDropOne(dnd, dndCallback)
    }

    $(morphEl).on('click', function ({target}) {
      // debugger
      if (target.hasAttribute('data-detach')) Morph.detach(target)
    })
  }

  static setImagePath(morphedEl) {
    let imagePath = $(morphedEl).find('[data-path]')
    if (imagePath) {
      return imagePath.dataset.path
    }
    return ''
  }

  static prepareData(context) {
    let data = {}
    data.morph = {}
    data.morphed = {}

    // debugger
    data.morph.type = context.morphModel
    data.morph.id = context.morphId
    data.morph.slug = context.slug
    data.morph.path = context.path

    data.morphed.type = context.morphedModel
    data.morphed.id = context.morphedId

    return data
  }

  static async dndCallback(files) {
    let url = `/adminsc/${this.morphModel}/attach${this.oneOrMany}`

    let data = Morph.prepareData(this)
    data = objAndData2FormData(data, files)

    let res = await post(url, data)
    if (res.arr) {
      Morph.appendTo(this, res.arr)
    }

  }

  static appendTo(self, srcs) {

    if (self.append) {
      let el = self.append
      // debugger
      if (self.oneOrMany === 'many') {
        Morph.appendManyImages(el, srcs)
      } else {
        Morph.appendOneImage(el, srcs)
      }
    }
  }

  static async detach(target) {
    let container = target.closest('.wrap')
    let morphedType = target.closest('.item_wrap').dataset.model
    let morphedId = target.closest('.item_wrap').dataset.id
    let slug = target.closest('[data-morph-model]').dataset.morphSlug
    let morphType = target.closest('[data-morph-model]').dataset.morphModel
    let morphId = target.dataset.id
    let url = `/adminsc/${morphType}/detach`
    let data = {morphedType, morphedId, morphId, slug}
    let res = await post(url, data)
    if (res.success) {
      container.remove()
    }
  }

  static async attach(oneOrMany, files) {
    let container = target.closest('.wrap')
    let morphedType = target.closest('.item_wrap').dataset.model
    let morphedId = target.closest('.item_wrap').dataset.id
    let slug = target.closest('.morph').dataset.slug
    let morphType = target.closest('.morph').dataset.type
    let morphId = target.dataset.id
    let url = `/adminsc/${morphType}/detach`
    let data = {morphedType, morphedId, morphId, slug}
    let res = await post(url, data)
    if (res.success) {
      container.remove()
    }
  }


  static appendOneImage(appendTo, image) {
    let img = $(appendTo)[0].querySelector('img')
    if (!img) {
      Morph.renderImage(appendTo, image)
    } else {
      img.src = image?.src
    }
  }

  static appendManyImages(appendTo, srcArr) {

    srcArr.forEach((image) => {
      Morph.renderImage(appendTo, image)
    })
  }

  static renderImage(appendTo, image) {
    let holder = $(appendTo)[0]
    let img = document.createElement('img')
    img.src = image.src
    let del = document.createElement('div')
    del.setAttribute('data-detach','')
    del.classList.add('detach')
    del.dataset.id = image.id
    del.innerText = 'x'
    let item = document.createElement('div')
    item.classList.add('item')
    item.appendChild(img)
    let wrap = document.createElement('div')
    wrap.classList.add('wrap')
    wrap.appendChild(item)
    wrap.appendChild(del)
    holder.appendChild(wrap)
  }
}