import {$, post} from '../../common'
export let test = {
    id:$('.test-name').value(),
    name:$('.test-name').el[0].innerText,
    del: async function(this.id){
        await post('/test/delete',{id})
        return JSON.parse(res)
    },
}