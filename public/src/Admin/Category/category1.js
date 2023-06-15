import '../Product/product.scss'
import './category.scss'
import {$, getToken, post} from "../../common";
import Imageable from '../Image/Imageable';
import Category from '../Category/Category';

import Morph from "../../components/morph/morph";

export default function category() {

  let $category = $(`.item-wrap[data-model='category']`)[0];
  if (!$category) return false;

  let dto = {
    id: +$category.dataset.id,
  };

  let dnds = $('[data-dnd]');
  dnds.forEach((dnd) => {
    if (dnd.parentNode.dataset.morphModel) {
      let m = new Morph(dnd, $category)
    }
  });

  debugger;
  let parent_category = $(`[data-field='category_id']`).first();
  if (parent_category) {
    parent_category.addEventListener('customSelect.changed', attachCategory.bind(dto))
  }

  let addPropertyBtn = $('.add-property').first()
  if (addPropertyBtn){
    addPropertyBtn.onclick = newRow.bind($('.properties').first())
  }
}

function newRow(){
  let $clone = this.querySelector('.rows .none .row').cloneNode(true)
  let $rows = this.querySelector('.rows')
  $rows.append($clone)
}
function attachCategory({detail}) {
  debugger;
  let data = {
    id: this.id,
    category_id: +detail.next.value,
  };
  post('/adminsc/category/updateOrCreate', data)

}

async function addMainImg(files) {
  let catId = $('.item-wrap')[0].dataset.id;
  let slugNameId = 1;
  let imagable = new Imageable();
  let morph = await new Morph(imagable, new Category(catId, slugNameId), files);

  let src = await post(imagable.urlOne, morph?.data);
  let appendTo = ".image[data-model='category']";
  let appendOneImage = morph.appendOneImage(appendTo, src?.arr[0])
}
