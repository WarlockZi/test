import './rights.scss';
import {$, popup, post} from '../../common';

export default function init(){

$('.rights-table .right')
  .on('click', function (e) {

    let el = e.target
    let $right = this
    let right = {
      id: $(this).find('.id').innerText,
      name: $(this).find('.name').innerText,
      description: $(this).find('.description').innerText,
    }

    if (el.classList.contains('del')) {
      if (right.id) {
        del(right.id)
      }

    } else if (el.classList.contains('save')) {
      if (right.id) {
        update()
      } else {
        create()
      }
    }

    async function update(e) {
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
