import './admin.scss'
import './components/main-menu/admin_main_menu'

import '../components/header/header-adm'
import '../components/accordion/accordion'

import './CRM/test_results/test_results'
import '../Test/do'
import '../Test/test-edit'

import {$} from '../common'
import   {_cache} from "./model/cache";

$('.clearCache').on('click', _cache.clearCache)