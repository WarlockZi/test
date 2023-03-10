import {$, objAndData2FormData, post} from "../../common";
import {dnd1} from "../dnd/dnd";

class Morph {
  constructor(morphEl) {
    this.url = '/adminsc/morph/attach'

    this.model = morphEl.closest('.item_wrap').dataset.model
    this.id = morphEl.closest('.item_wrap').dataset.id

    this.slug = morphEl.dataset.morphSlug
    this.oneOrMany = morphEl.dataset.morphOneormany
    this.relation = morphEl.dataset.morphRelation

    let detaches = $(morphEl)[0].querySelectorAll('[data-detach]');
    [].forEach.call(detaches, (detach) => {
      detach.onclick = this.detach.bind(this)
    })

    debugger
    let dnds = $(morphEl)[0].querySelectorAll('.holder');
    [].forEach.call(dnds, (dnd) => {
      new dnd1(this.attach.bind(this))
      // detach.onclick = this.detach.bind(this)
    })

    let dndCallback = Morph.dndCallback.bind(this)
  }
  async attach(files, target, context) {
    let morphedType = context.model
    let morphedId = context.id
    let path = target.dataset.dndPath
    if (target.parentNode.dataset.morphOneormany === 'one') {
      let fr = Array.prototype.slice.call(files, 0, 1);
    }
    let relation = context.relation
    debugger
    let url = `/adminsc/${morphedType}/attach`
    let param = {morphedType, morphedId, relation, path}
    param = objAndData2FormData(param, files)
    let res = await post(url, param)
  }

  async detach({target}) {
    debugger
    let url = `/adminsc/${this.model}/detach`
    let data = this
    data.morphId = target.dataset.id
    let res = await post(url, data)
    if (res.success) {
      container.remove()
    }
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
    data.morph.oneOrMany = context.oneOrMany
    data.morph.function = context.oneOrMany

    data.morphed.type = context.morphedModel
    data.morphed.id = context.morphedId

    return data
  }

  static async dndCallback(files) {

// debugger
    let data = Morph.prepareData(this)
    data = objAndData2FormData(data, files)

    let res = await post(this.url, data)
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





  static appendOneImage(appendTo, image) {
    let img = $(appendTo)[0].querySelector('img')
    if (!img) {
      Morph.renderImage(appendTo, image)
    } else {
      img.src = image?.src
    }
  }

  static setImagePath(morphedEl) {
    let imagePath = $(morphedEl).find('[data-path]')
    if (imagePath) {
      return imagePath.dataset.path
    }
    return ''
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
    del.setAttribute('data-detach', '')
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

export default function morph() {
  let morphs = $('[data-morph-relation]')
  if (morphs) {
    // debugger
    morphs.forEach((morph) => {
      new Morph(morph)
    })
  }
}