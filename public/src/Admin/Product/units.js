import './units.scss'
import {$} from '../../common'
import UnitTable from '../Unit/UnitTable'

  let $units = $('.units').first();
  if ($units) {
    $(`[data-tab='3']`).first().classList.toggle('show');
    $(`[data-tab='1']`).first().classList.toggle('show');

    new UnitTable('.units')

}
