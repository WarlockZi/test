import {$, post} from '../../common'

export function Test (){
    this.id = $('.test-name').value()
    this.name = $('.test-name').el[0].innerText

    this.delete = async function(){
        await post('/test/delete',{id:this.id})
        return JSON.parse(res)
    }
}