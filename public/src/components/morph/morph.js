import {$, post, objAndData2FormData} from "../../common";
import DragNDrop from "../dnd/DragNDrop";
import DragNDropMany from "../dnd/DragNDropMany";
import DragNDropOne from "../dnd/DragNDropOne";

export default class Morph {

  constructor(morphEl, morphedEl) {
    this.morphEl = morphEl
    this.morphedEl = morphedEl

    this.imagePath = Morph.setImagePath(morphedEl)
    this.appendTo = Morph.setAppendTo(morphedEl)

    let dndContainer = morphEl.querySelector(`[data-dnd]`)
    if (dndContainer) {
      this.oneOrMany = morphEl.dataset.morph
      // debugger
      let dndCallback = Morph.dndCallback.bind(this)

      if (this.oneOrMany === 'many') {
        new DragNDropMany(dndContainer, dndCallback)
      } else {
        new DragNDropOne(dndContainer, dndCallback)
      }
    }

    $(this.morphEl).on('click', function ({target}) {
      if (target.classList.contains('detach')) Morph.detach(target)
    })
  }

  static setImagePath(morphedEl) {
    let imagePath = $(morphedEl).find('[data-path]')
    if (imagePath) {
      return imagePath.dataset.path
    }
    return ''
  }

  static setAppendTo(morphedEl) {
    let appendTo = $(morphedEl).find('[data-appendto]')
    if (appendTo) {
      return '.' + appendTo.dataset.appendto
    }
    return ''
  }

  static prepareData(morphEl, morphedEl) {
    let data = {}
    data.morph = {}
    data.morphed = {}

    data.morphed.type = morphedEl.dataset.model
    data.morphed.id = morphedEl.dataset.id

    data.morph.type = morphEl.dataset.model
    data.morph.slug = morphEl.dataset.slug
    data.morph.path = morphEl.dataset.path

    return data
  }

  static async dndCallback(files) {
    // debugger
    let url = `/adminsc/${this.morphEl.dataset.model}/attach${this.oneOrMany}`

    let data = Morph.prepareData(this.morphEl, this.morphedEl)
    data = objAndData2FormData(data, files)

    let res = await post(url, data)
    if (res.arr) {
      Morph.appendTo(this, res.arr)
    }

  }

  static appendTo(self, srcs) {

    if (self.appendTo) {
      let el = self.morphEl.closest(self.appendTo)
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
    let slug = target.closest('[data-morph]').dataset.slug
    let morphType = target.closest('[data-morph]').dataset.model
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
      // let holder = $(appendTo)[0]
      // let img = document.createElement('img')
      // img.src = image?.src
      // holder.appendChild(img)
      Morph.renderImage(appendTo,image)
    } else {
      img.src = image?.src
    }
  }

  static appendManyImages(appendTo, srcArr) {

    srcArr.forEach((image) => {
      Morph.renderImage(appendTo,image)
    })
  }

  static renderImage(appendTo, image) {
    let holder = $(appendTo)[0]
    let img = document.createElement('img')
    img.src = image.src
    let del = document.createElement('div')
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