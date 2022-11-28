import './category.scss'
import {$} from "../../common";
import Imageable from '../Image/Imageable';
import Category from '../Category/Category';
import {dnd1} from "../../components/dnd/dnd";
import Morph from "../../components/morph/morph";
import addSingleImage from "../Image/AddSingleImage";
import DragNDrop from "../../components/dnd/DragNDrop";

let url = '/adminsc/category/addMainImage'
let tag = `category`
let deltag = `delMainImage`

// let singleImage = new addSingleImage(appendTo,deltag)
// Вороник Виталий Викторович
// 4751

let el = $(`[data-field="image_main"]`)[0]
new DragNDrop(el, addMainImg, true, null)

async function addMainImg(file) {

  let catId = $('.item_wrap')[0].dataset.id
  let data = {file}
  let morph = await new Morph(new Imageable, new Category(catId), data)
  let appendTo = $(`.image[data-model="category"]`)[0]
  let appendOneImage = morph.appendOneImage(appendTo)

}



// dnd1('.add_main_image',
//   handleMainImage.bind(null, appendTo, url, tag)
// )