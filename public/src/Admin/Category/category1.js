import './category.scss'
import {$, post} from "../../common";
import Imageable from '../Image/Imageable';
import Category from '../Category/Category';

import Morph from "../../components/morph/morph";
import DragNDrop from "../../components/dnd/DragNDrop";

let sel = "[data-field='image_main']"
new DragNDrop(sel, addMainImg, true, null)

async function addMainImg(files) {
  let catId = $('.item_wrap')[0].dataset.id
  let slugNameId = 1
  let imagable = new Imageable()
  let morph = await new Morph(imagable, new Category(catId,slugNameId), files)

  let src = await post(imagable.urlOne, morph?.data)
  let appendTo = ".image[data-model='category']"
  let appendOneImage = morph.appendOneImage(appendTo,src?.arr[0])
}
