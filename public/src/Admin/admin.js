import './admin.scss'
import './components/main-menu/admin_main_menu'

import '../components/header/header-adm'
import '../components/accordion/accordion'

import './CRM/test_results/test_results'
import '../Test/do'
import '../Test/test-edit'

import {$} from '../common'
import {_cache} from "./model/cache";

$('.clearCache').on('click', _cache.clearCache)

// $('.breadcrumbs-adm').on('click', api)
//
// async function api(e) {
//   let res = await fetch('http://127.0.0.1:8000/api/v1/tests-tree')
//   e.target.innerHTML = res
// }

