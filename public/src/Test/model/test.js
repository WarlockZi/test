import {$, popup, post} from '../../common'

export const _test = {

  nextQ: () => {
    let current = _test.currentQ()
    if (current.id > current.navLength - 2) return false

    let aimNavId = _test.aimNavIdFunction(current.id, 'next')
    let aimQEl = _test.aimQElFunction(current, 'next')

    _test.pushNav(current.id, aimNavId)
    _test.pushQ(current.QEl, aimQEl)
  },

  prevQ: () => {
    let current = _test.currentQ()
    if (current.id < 1) return false

    let aimNavId = _test.aimNavIdFunction(current.id, 'back')
    let aimQEl = _test.aimQElFunction(current, 'back')

    _test.pushNav(current.id, aimNavId)
    _test.pushQ(current.QEl, aimQEl)
  },

  pushNav: (currentId, aimNavId) => {
    let currNavEl = $('[data-pagination]')[currentId]
    currNavEl.classList.toggle('active')

    let NavEl = $('[data-pagination]')[aimNavId]
    NavEl.classList.toggle('active')
  },

  pushQ: (currentEl, aimQEl) => {
    currentEl.classList.toggle('show')
    aimQEl.classList.toggle('show')
  },

  aimNavIdFunction: (currentId, direction) => {
    let dir = currentId
    switch (true) {
      case direction === 'next':
        return dir += 1
        break
      case direction === 'back':
        return dir -= 1
        break
    }
  },

  aimQElFunction: (current, direction) => {
    switch (true) {
      case direction === 'next':
        return current.QNextEl
        break
      case direction === 'back':
        return current.QPrevEl
        break
    }
  },

  currentQ: () => {
    return {
      id: $('.active')[0].innerText - 1,
      QEl: $('.question.show')[0],
      navLength: $('[data-pagination]').length,
      QPrevEl: $('.question.show')[0].previousElementSibling,
      QNextEl: $('.question.show')[0].nextElementSibling,
    }
  },


  viewModel: () => {
    return {
      id: +window.location.href.split('/').pop(),
      test_name: $('#test_name').text(),
      enable: $('#enable')[0],
      parent: $('select').selectedIndexValue(),
    }
  },

  id: (id) => {
    return id ?? $('.test-name')[0].dataset.testid
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
    res = await JSON.parse(res)
    if (res) {
      window.location.href = `/adminsc/test/edit/${res.id - 1}`
    }
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
    res = await JSON.parse(res)
    debugger
    if (res) {
      window.location.href = `/adminsc/test/edit/${res.id}`
    }
  },

  selectedValueCustomSelect(className) {
    let select = $(`[data-field=${className}]`)[0]
    let selected = [...select.options].filter((opt) => opt.selected)
    if (selected) {
      return +selected[0].value
    }
  },

  serverModel: () => {
    let id = !!+window.location.href.split('/').pop()
    id = id?id:0
    let model = {
      id,
      test_name: $('#name.field')[0].value,
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
    res = await JSON.parse(res)
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
    res = await JSON.parse(res)
    if (res.notAdmin) {
      popup.show('Видимость теста скрыта. Чтобы удалить полностью - обратитесь к ГД')
      setTimeout(() => {
        window.location = '/adminsc/test/edit/400'
      }, 4000)
    } else {
      window.location = '/adminsc/test/edit/400'
    }

  },

}