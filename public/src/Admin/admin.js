import './admin.scss'
import './components/main-menu/admin_main_menu'

// import './components/admin_catalog_menu.scss'
import '../components/header/header'
import '../components/accordion/accordion'

import './CRM/test_results/test_results'
import '../Test/do'
import '../Test/test-edit'

import {$} from '../common'
import   {_cache} from "./model/cache";

// import { library, dom } from "@fortawesome/fontawesome-svg-core";
//
// import { fas } from '@fortawesome/free-solid-svg-icons'
// import { far } from '@fortawesome/free-regular-svg-icons'
// import { fab } from '@fortawesome/free-brands-svg-icons'
//
// library.add(fas, far, fab)
//
// dom.i2svg()
//
// import { faHouseUser} from "@fortawesome/free-solid-svg-icons/faHouseUser";
// import '@fortawesome/fontawesome-free/js/fontawesome'
// import '@fortawesome/fontawesome-free/js/solid'
// import '@fortawesome/fontawesome-free/js/regular'
// import '@fortawesome/fontawesome-free/js/brands'

// library.add(faHouseUser);
// dom.watch();

$('.clearCache').on('click', _cache.clearCache)