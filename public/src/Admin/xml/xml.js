import './xml.scss'
import {$} from '../../common'

let files = $('.file').on('click', clickHandle)

function clickHandle({target}){
  let container = target.closest('.xml')
  if (!container) return false
  let input = container.querySelector('input')
  input.value = target.innerText

}