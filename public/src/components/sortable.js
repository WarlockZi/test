import Sortable from 'sortablejs'
import {$, post} from '../common'

export default function sortable(containerSelector, elSelector, model) {

  debugger
  let container = $(containerSelector)[0];
  if (container) {

    let sortable = Sortable.create(container, {
      animation: 150,
      onEnd: function (evt) {
        let oldI = evt.oldIndex
        let newI = evt.newIndex
        if (oldI > newI) {
          sort(oldI)
        } else {
          sort(newI)
        }

        async function sort(upToQestionNumber) {
          let els = $(elSelector);
          els.length = upToQestionNumber-1

          let toChange = els.map((el) => {
            return el.dataset.id
          })

          let res = await post(`/adminsc/${model}/sort`, {toChange})
          els.map((el, i) => {
            $(el).find('.sort').innerText = i + 1
          })
        }
      },
    })

  }
}