import '../admin'
import './admin.scss'
import '../normalize.scss'
import './admin_catalog_menu.scss'
import '../components/header/header'

import {$} from '../common'
import   {_cache} from "./model/cache";


$('.clearCache').on('click', _cache.clearCache)