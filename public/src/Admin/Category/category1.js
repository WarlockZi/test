import './category.scss'
import {$} from "../../common";
import Imageable from '../Image/Imageable';
import Category from '../Category/Category';

import Morph from "../../components/morph/morph";
import DragNDrop from "../../components/dnd/DragNDrop";

let url = '/adminsc/category/addMainImage'
let tag = `category`
let deltag = `delMainImage`


// Вороник Виталий Викторович
// 4751

let sel = "[data-field='image_main']"
new DragNDrop(sel, addMainImg, true, null)

async function addMainImg(file) {

  let catId = $('.item_wrap')[0].dataset.id
  let morph = await new Morph(new Imageable, new Category(catId), {file})
  let appendTo = ".image[data-model='category']"
  let appendOneImage = morph.appendOneImage(appendTo)

}
