import {$, popup, post} from '../../common'

export let _test = {

    serverModel: () => {
        return {
            id: +window.location.href.split('/').pop(),
            test_name: $('#test_name').text(),
            enable: 1,
            isTest: +!$('#isPath').checked(),
            sort: 0,
            parent: $('select').selectedIndexValue(),
        }
    },
    id: (id) => {
        return id ?? $('.test-name').value()
    },

    path_create: async () => {
        let test_path = _test.serverModel()
        test_path.id = 0
        test_path.isTest = 0
        let url = `/test/create`
        let res = await post(url, test_path)
        res = await JSON.parse(res)
        if (res) {
            window.location.href = `/adminsc/test/edit/${res.id-1}`
        }
    },

    name: () => {
        return $('.test-name').el[0].innerText
    },

    create: async () => {
        let test_path = _test.serverModel()
        test_path.id = 0
        test_path.isTest = 1
        let url = `/test/create`
        let res = await post(url, test_path)
        res = await JSON.parse(res)
        if (res) {
            window.location.href = `/adminsc/test/edit/${res.id-1}`
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
        let serverModel = _test.serverModel()
        let res = await post('/test/delete', {id: serverModel.id})
        res = await JSON.parse(res)
        if (res){
            popup('Видимость теста скрыта. Чтобы удалить полностью - обратитесь к ГД')
            window.location = '/adminsc/test/edit/400'
        }
    },

}