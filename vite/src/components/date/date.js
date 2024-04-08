import {$, fragmentDate} from '../../common'
import './date.scss'

let dates = $('[custom-date]')

if (dates){
  for (let date of dates) {
    date.onchange = function ({target}) {
      let {yyyy,mm,dd} = fragmentDate(target.value)

      let formated = `${yyyy}-${mm}-${dd}`
      let d = target.value
      target.setAttribute('data-value',formated)
    }

  }
}
