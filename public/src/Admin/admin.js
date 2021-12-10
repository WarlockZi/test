import './components/main-menu/admin_main_menu'
import './admin.scss'
import '../normalize.scss'
import './admin_catalog_menu.scss'
import '../components/header/header'
import '../components/accordion/accordion'

import './CRM/test_results/test_results'

import {$} from '../common'
import   {_cache} from "./model/cache";


$('.clearCache').on('click', _cache.clearCache)