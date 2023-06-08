import './units.scss'
import {$} from '../../common'
import Unit from '../Unit/Unit'

  let $units = $('.units').first();
  if ($units) {
    $(`[data-tab='7']`).first().classList.toggle('show');
    $(`[data-tab='1']`).first().classList.toggle('show');

    new Unit('.units')

}
