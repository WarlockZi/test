import './rights.scss';
import {$, popup, post} from '../../common';

export default function rights() {

  $('.rights-table')
    .on('click', function (e) {

      let el = e.target
      let dataId = el.dataset.id??'new'
      let fields = $(`[data-id='${dataId}']`)
      let right = {}
      right.right = {}
      fields.map((f) => {
        if (f.classList.contains('id')) {
          right.id = f
          right.right.id = f.dataset.id
        } else if (f.classList.contains('name')) {
          right.name = f
          right.right.name = f.innerText
        } else if (f.classList.contains('description')) {
          right.description = f
          right.right.description = f.innerText
        } else if (f.classList.contains('save')) {
          right.save = f
        } else if (f.classList.contains('del')) {
          right.del = f
        }
      })


      if (el.classList.contains('del')) {
        if (right.id) {
          del(right.id)
        }

      } else if (el.classList.contains('save')) {
        if (right.right.id != 'new') {
          update(right.right)
        } else {
          create(right.right)
        }
      }

      async function update(right) {
        let res = post('/right/update', right)
      }

      async function create(e) {
        let res = await createOnServer()
      }

      async function createOnServer() {
        let res = await post('/right/create', right)
        res = await JSON.parse(res)
        if (res.id) {
          let rightClone = $right.cloneNode(true)
          $right.after(rightClone)
          $(rightClone).find('.id').innerText = res.id
          $($right).find('.name').innerText = ''
          $($right).find('.description').innerText = ''
        }
      }


      async function delServer(id) {
        let res = await post('/right/delete', {id})
        res = await JSON.parse(res)
        if (res.msg === 'ok') {
          popup.show('Удалено')
        }
      }

      function delDom(e) {
        $right.remove()

      }

      function del(id) {
        if (confirm("Удалить право?")) {
          let r = e.target
          delDom(id)
          delServer(id)
        }
      }

    })
}

