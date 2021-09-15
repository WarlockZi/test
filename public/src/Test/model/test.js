import {$, popup, post} from '../../common'

export let _test = {

    serverModel: () => {
        return {
            id: +window.location.href.split('/').pop(),
            test_name: $('#test_name').text(),
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