import {$} from '../common'

export default function getSex() {
  function sex() {
    const s = $('[name="sex"]')
    for (let f of s) {
      if (f.checked) {
        return f.value
      }
    }
    return 'm'
  }
}