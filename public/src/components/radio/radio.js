import './radio.scss'
import {$} from '../../common'

export default function radio(){
  let radios = $('[custom-radio]');

  [].map.call(radios, function (radio) {
    $(radio).on('click',handleClick)

    function handleClick({target}) {
      let targ = target.closest("label")
      radio.dataset.value = targ.dataset.value
    }

  })

}