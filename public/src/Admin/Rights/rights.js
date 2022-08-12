import './rights.scss';
import {$, popup, post} from '../../common';

export default function rights() {

  $('.rights-table').on('click', handle)

  function handle({target}) {
    if (target.closest('.del')) del(target.closest('.del'))
    if (target.closest('.save')) save(target.closest('.save'))

    function model(el) {
      let dataId = el.dataset.id ?? 'new'
      let fields = $(`[data-id='${dataId}']`)
      let model = {}
      model.toServ = {}
      model.empty = {}

      fields.map((f) => {
        if (f.classList.contains('id')) {
          model.id = f
          model.toServ.id = f.dataset.id
        } else if (f.classList.contains('name')) {
          model.name = f
          model.toServ.name = f.innerText.trim()
        } else if (f.classList.contains('description')) {
          model.description = f
          model.toServ.description = f.innerText.trim()
        } else if (f.classList.contains('save.svg')) {
          model.save = f
        } else if (f.classList.contains('del')) {
          model.del = f
        }
      })

      model.empty.del = model.id.previousElementSibling.cloneNode(true)
      model.empty.save = model.id.previousElementSibling.previousElementSibling.cloneNode(true)
      model.empty.description = model.id.previousElementSibling.previousElementSibling.previousElementSibling.cloneNode(true)
      model.empty.name = model.id.previousElementSibling.previousElementSibling.previousElementSibling.previousElementSibling.cloneNode(true)
      model.empty.id = model.id.previousElementSibling.previousElementSibling.previousElementSibling.previousElementSibling.previousElementSibling.cloneNode(true)

      return model
    }


    function del(el) {
      let mod = model(el)
      if (mod.toServ.id === 'new') return
      if (confirm("Удалить право?")) {
        delDom(mod)
        delServer(mod)
      }
    }

    async function delServer(model) {
      let res = await post('/right/delete', {id: model.toServ.id})
    }

    function delDom(model) {
      model.id.remove()
      model.name.remove()
      model.description.remove()
      model.save.remove()
      model.del.remove()
    }


    function save(el) {
      let mod = model(el)
      if (mod.toServ.id !== 'new') {
        update(mod.toServ)
      } else {
        if (!mod.toServ.name || !mod.toServ.description) return false
        create(mod)
      }
    }

    async function update(toServ) {
      let res = await post('/right/update', toServ)
    }

    function clearModel(model){
      model.name.innerText = ""
      model.description.innerText = ""
    }

    function createOnDom(model){
      let lastElement = $(".id[data-id='new']")[0]
      lastElement.before(model.empty.id)
      lastElement.before(model.empty.name)
      lastElement.before(model.empty.description)
      lastElement.before(model.empty.save)
      lastElement.before(model.empty.del)
    }

    function assignNewValuesOnClone(model, id){
      model.empty.id.dataset.id = id
      model.empty.id.innerText = id
      model.empty.name.dataset.id = id
      model.empty.name.innerText = model.name.innerText.trim()
      model.empty.description.dataset.id = id
      model.empty.description.innerText = model.description.innerText.trim()
      model.empty.save.dataset.id = id
      model.empty.del.dataset.id = id
    }

    async function create(model) {
      let res = await post('/right/create', model.toServ)

      if (res.arr.id) {

        assignNewValuesOnClone(model, res.id-1)
        createOnDom(model)
        clearModel(model)

        popup.show('Сохранено')
      }

    }


  }
}