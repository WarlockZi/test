import {$, post} from '../../common'

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
            window.location.href = `/adminsc/test/edit/${res.id}` + '?id=' + res.id + '&name=' + test_path.test_name
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
            window.location.href = `/adminsc/test/edit/${res.id}` + '?id=' + res.id + '&name=' + test_path.test_name
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
        let res = await post('/test/delete', {id: this.id})
        return await JSON.parse(res)
    },

}