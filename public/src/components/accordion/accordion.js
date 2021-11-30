import './accordion.scss'
import {$} from '../../common'

let handle = (e) => {
    let self = e.target
    let checkbox = self.previousSibling
    let arr = Array.from($('[type="checkbox"]'))

    arr.map((check)=>{
        if (checkbox !== check) check.checked= false
    })

}
$('label').on('click', handle)



