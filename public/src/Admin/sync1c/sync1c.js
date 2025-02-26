import './sync1c.scss'
import {Sync} from './Sync'
import {$} from '../../common'

let $sync = $('.sync').first();
if ($sync) {
  new Sync($sync)
}
