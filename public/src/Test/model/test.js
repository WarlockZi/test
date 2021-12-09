import {$, popup, post} from '../../common'

export const _test = {

  markCurrentInMenu: () => {
    let currentTestId = $('.test-name').el[0]
    if (currentTestId) {
      currentTestId = +currentTestId.getAttribute('value')
      let menuItemCollection = $('.accordion a').el
      Array.from(menuItemCollection).filter((a) => {
        if (+a.dataset.id === currentTestId) {
          a.classList.add('current')
        }
      })

    }
  },

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
    let currNavEl = $('[data-pagination]')
      .el[currentId]
    currNavEl.classList.toggle('nav-active')

    let NavEl = $('[data-pagination]')
      .el[aimNavId]
    NavEl.classList.toggle('nav-active')
  },

  pushQ: (currentEl, aimQEl) => {
    currentEl.classList.toggle('flex1')
    aimQEl.classList.toggle('flex1')
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
        return current.QPrevc
        break
    }
  },

  currentQ: () => {
    return {
      id: $('.nav-active').el[0].innerText - 1,
      QEl: $('.question.flex1').el[0],
      navLength: $('[data-pagination]').el.length,
      QPrevc: $('.question.flex1').el[0].previousElementSibling,
      QNextEl: $('.question.flex1').el[0].nextElementSibling,
    }
  },


  serverModel: () => {
    return {
      id: +window.location.href.split('/').pop(),
      test_name: $('#test_name').el[0].value,
      enable: +$('#enable').el[0].checked,
      isTest: +$('[isTest]').el[0].getAttribute('isTest'),
      parent: $('select').selectedIndexValue(),
    }
  },

  viewModel: () => {
    return {
      id: +window.location.href.split('/').pop(),
      test_name: $('#test_name').text(),
      enable: $('#enable').el[0],
      parent: $('select').selectedIndexValue(),
    }
  },

  id: (id) => {
    return id ?? $('.test-name').value()
  },
  children: () => {
    let arrChildren = $('.children').el
    if (!arrChildren[0].innerText === 'не содержит')
      return arrChildren.length
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
    return $('.test-name').el[0].innerText
  },

  create: async () => {
    let test = _test.serverModel()
    test.id = 0
    test.isTest = 1
    let url = `/test/updateOrCreate`
    let res = await post(url, test)
    res = await JSON.parse(res)
    if (res) {
      window.location.href = `/adminsc/test/edit/${res.id - 1}`
    }
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

    let viewModel = _test.viewModel()
    viewModel.enable.checked = false
    let serverModel = _test.serverModel()
    let res = await post('/test/delete', {
      test: serverModel
    })
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