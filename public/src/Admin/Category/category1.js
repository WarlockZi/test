import '../Product/product.scss'
import './category.scss'
import {$, post} from "../../common";
import Imageable from '../Image/Imageable';
import Category from '../Category/Category';

import Morph from "../../components/morph/morph";


export default function category() {

  let category = $(`.item_wrap[data-model='category']`)[0]
  if (!category) return false

  // let morphs = $('[data-morph-model]')
  let dnds = $('[data-dnd]')

  // debugger
  dnds.forEach((dnd) => {
    if (dnd.parentNode.dataset.morphModel) {
      let m = new Morph(dnd, category)
    } else if (dnd.parentNode.dataset.belongsTo) {
      let m = new BelongsTo(dnd, category)
    }
  })
}
// let sel = "[data-field='image_main']"
// new DragNDrop(sel, addMainImg, true, null)

async function addMainImg(files) {
  let catId = $('.item_wrap')[0].dataset.id
  let slugNameId = 1
  let imagable = new Imageable()
  let morph = await new Morph(imagable, new Category(catId, slugNameId), files)

  let src = await post(imagable.urlOne, morph?.data)
  let appendTo = ".image[data-model='category']"
  let appendOneImage = morph.appendOneImage(appendTo, src?.arr[0])
}
