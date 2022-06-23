import {$, popup, post} from '../../common'

export const _test = {


  viewModel: () => {
    return {
      id: +window.location.href.split('/').pop(),
      name: $('#test_name').text(),
      enable: $('#enable')[0],
      parent: $('select').selectedIndexValue(),
    }
  },

  children: () => {
    let childrenLenght = $('.children').length
    if (childrenLenght)
      return childrenLenght
    return false
  },

  path_create: async () => {
    let test_path = _test.serverModel()
    test_path.id = 0
    test_path.isTest = 0
    let url = `/test/create`
    let res = await post(url, test_path)
    if (res) {
      window.location.href = `/adminsc/test/edit/${res.id - 1}`
    }
  },

  id: (id) => {
    return id ?? $('.test-name')[0].dataset.testid
  },
  name: () => {
    return $('.test-name')[0].innerText
  },

  create: async () => {
    let test = _test.serverModel()
    test.id = 0
    test.isTest = 1
    let url = `/test/updateOrCreate`
    let res = await post(url, test)
    debugger
    if (res) {
      window.location.href = `/adminsc/test/edit/${res.arr.id}`
    }
  },


  serverModel: () => {
    let id = !!+window.location.href.split('/').pop()
    id = id ? id : 0
    let model = {
      id,
      name: $('#name.field')[0].value,
      isTest: +$('[isTest]')[0].getAttribute('isTest'),
    }
    // debugger
    let fields = $('[custom-select]');
    [].forEach.call(fields, function (field) {
      model[field.dataset['field']] = field.dataset['id']
    })
    return model
  },

  update: async () => {
    let model = _test.serverModel()
    let url = `/adminsc/test/update/${model.id}`
    let res = await post(url, model)
    if (res) {
      window.location.href = `/adminsc/test/edit/${model.id}`
    }
  },

  delete: async function () {

    if (_test.children()) {
      popup.show('Сначала удалите все тесты из папки')
      return false
    }

    let id = _test.id()
    let res = await post('/adminsc/test/delete', {id})
    if (res.notAdmin) {
      popup.show('Видимость теста скрыта. Чтобы удалить полностью - обратитесь к ГД')
      setTimeout(() => {
        window.location = '/adminsc/test/edit/400'
      }, 4000)
    } else {
      window.location = '/adminsc/test/edit/400'
    }

  },
  // selectedValueCustomSelect(className) {
  //   let select = $(`[data-field=${className}]`)[0]
  //   let selected = [...select.options].filter((opt) => opt.selected)
  //   if (selected) {
  //     return +selected[0].value
  //   }
  // },

}
