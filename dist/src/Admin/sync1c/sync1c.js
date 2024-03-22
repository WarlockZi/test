import './sync1c.scss'
import {Sync} from './Sync'
import {$, popup, post} from '../../common'

let $sync = $('.sync').first();
if ($sync) {
  new Sync($sync)
}
