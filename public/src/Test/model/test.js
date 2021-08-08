import {$, post} from '../../common'

export function _test (id=0){

    this.id = id ?? $('.test-name').value()
    this.name = $('.test-name').el[0].innerText

    this.create = function(){

    }

    this.delete = async function(){
        await post('/test/delete',{id:this.id})
        return JSON.parse(res)
    }
}