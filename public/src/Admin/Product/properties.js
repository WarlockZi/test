import {$} from '../../common'
import Property from '../Property/Property'

let $properties = $('.property');
if ($properties) {

  $properties.forEach(($prop) => {
    new Unit('.units')
  })


}