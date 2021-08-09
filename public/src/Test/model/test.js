import {$, post} from '../../common'

export let _test = {
    id: (id) => {
        return id ?? $('.test-name').value()
    },
    name: () => {
        return $('.test-name').el[0].innerText
    },
    create: () => {

    },
    delete: async function(){
        let res = await post('/test/delete', {id: this.id})
        return await JSON.parse(res)
    },

}