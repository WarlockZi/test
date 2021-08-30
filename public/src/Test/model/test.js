import {$, post} from '../../common'

export let _test = {
    serverModel:
        {
            id: +window.location.href.split('/').pop(),
            test_name: $('#test_name').text(),
            enable: 1,
            isTest: +!$('#isPath').checked(),
            sort: 0,
            parent: $('select').selectedIndexValue(),
        },
    id: (id) => {
        return id ?? $('.test-name').value()
    },
    name: () => {
        return $('.test-name').el[0].innerText
    },
    create: async () => {
        _test.createUpdate('/test/create')
    },

    update: async () => {
        let model = _test.serverModel
        let url = `/adminsc/test/update/${model.id}`
        let res = await post(url, model)
        res = await JSON.parse(res)
        if (res) {
            window.location.href = `/adminsc/test/edit/${res.id}` + '?id=' + res.id + '&name=' + model.test_name
        }
    },

    delete: async function () {
        let res = await post('/test/delete', {id: this.id})
        return await JSON.parse(res)
    },

}