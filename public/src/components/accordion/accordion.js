import './accordion.scss'
import {$, post} from '../../common'

export let acc = {
     init :async (params)=>{
        let tree = await post('Tree',
            {'table':' Test'}
            )
    }
}


