import {$, post} from '../../common'

export let _test = {
    serverModel:
        {
            id: $('#test_name').el[0].innerText,
            test_name: $('#test_name').el[0].innerText,
            enable: 1,
            isTest: +!$('#isPath').el[0].checked,
            sort: 0,
            parent: $('select').el[0].options[$('select').el[0].selectedIndex].value,
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

    update: () => {
        let url = window.location.href
        let id = +url.split('/').pop()
        _test.createUpdate(`/test/update/${id}`)
    },

    createUpdate: async (url) => {
        let model = _test.serverModel
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