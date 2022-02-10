import './rights.scss';
import {$, popup, post} from '../../common';

export default function rights() {

  $('.rights-table').on('click', handle)

  // $('.rights-table')
  // .on('click', ['.save', '.save svg'], updateOrCreate)

  function handle(e) {
    let right = model(e)
    if (e.target.closest('.del')) del(right)
    if (e.target.closest('.save')) save(right)

  }

  function model(e) {
    // if (!['id', 'name', 'description', 'save', 'del'].includes(e.target.classList[0])) return false
    let svg = e.target.tagName === 'svg' ? true : false
    let el = svg ? e.target.parentNode : e.target
    let dataId = el.dataset.id ?? 'new'
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
    return right
  }

  function del(model) {
    if (model.right.id === 'new') return
    if (confirm("Удалить право?")) {
      delDom(model)
      delServer(model)
    }
  }

  async function delServer(model) {
    let res = await post('/right/delete', {id: model.right.id})
    res = await JSON.parse(res)
    if (res.msg === 'ok') {
      popup.show('Удалено')
    }
  }

  function delDom(model) {
    model.id.remove()
    model.name.remove()
    model.description.remove()
    model.save.remove()
    model.del.remove()
  }


  function save(right) {
    if (right.right.id != 'new') {
      update(right.right)
    } else {
      if (!right.right.name || !right.right.description) return false
      create(right)
    }
  }

  async function update(right) {
    let res = await post('/right/update', right)
    if (await JSON.parse(res).updated) {
      popup.show('Обновлено')
    }
  }

  async function create(right) {
    // let res = await post('/right/create', right.right)
    // res = await JSON.parse(res)
let res = right

    let lastElement = $(".id[data-id='new']")[0]
    if (true) {
      // let rightClone = $right.cloneNode(true)

      right.id.dataset.id=res.id
      lastElement.before(right.id.cloneNode(true))

      right.name.dataset.id=res.id
      lastElement.before(right.name.cloneNode(true))

      right.description.dataset.id=res.id
      lastElement.before(right.description.cloneNode(true))

      right.save.dataset.id=res.id
      lastElement.before(right.save.cloneNode(true))
      right.del.dataset.id=res.id
      lastElement.before(right.del.cloneNode(true))








      popup.show('Сохранено')
    }
  }

  // async function createOnServer(right) {
  //
  // }

}