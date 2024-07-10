import './admin.scss'
import './model/cache.js';

import '../components/header/header-adm.js'
import '../components/search/search.js'
import '../components/accordion/accordion.js'
import '../components/admin_sidebar.js'
import '../components/date/date.js'

import {$} from "../common.js"

import '../Test/test_results/test_results.js'
import '../Test/opentest-edit.js'
import testEdit from '../Test/test-edit.js'
import '../Test/do.js'
import '../Test/open_test.js'


import './sync1c/sync1c.js'
// import './chart/chart'.js
import './chartjs/chartjs.js'
import quill from '../components/quill/quill.js'


import './Planning/planning.js'
import './Settings/settings.js'
import './Videoinstructions/videoinstructions.js'
import './Category/category1.js'
import rights from './Rights/rights.js'
import category from './Category/category1.js'

import user from './User/user.js'


import radio from '../components/radio/radio.js'
import multiselect from '../components/multiselect/multiselect.js'
import catalogItem from '../components/catalog-item/catalog-item.js'
import tooltips from '../components/tooltip/tooltip.js'
import error from '../components/error/error.js'
import select from '../components/select/select.js'
import accordionShow from '../components/accordion-show.js'
import morph from '../components/morph/morph.js'
import Search from "../components/search/search.js"
import Promotion from "../Promotions/Promotion.js"
import './ProductFilter/ProductFilter'
// import Order from "../Admin/Order/order.js"
// import pagination from './Product/pagination.js'
// import product from './Product/product.js'
import {qs} from '../constants'
$(document).ready(async function () {

    if (document[qs](`.item-wrap[data-model='product']`)) {
        const {default: prod} = await import('./Product/product.js')
        prod();
    }
    if (document[qs]('.order-edit')) {
        const {default: Order} = await import('./Order/order.js')
        new Order()
    }

    if (document[qs]('.modal-wrapper')){
        const {default:Modal} = await import("../components/Modal/modal.js")
        new Modal()
    }
    new Promotion();
    new Search(true);

    morph();
    navigate(window.location.pathname);
    radio();
    multiselect();
    catalogItem();
    tooltips();
    quill();
    accordionShow();

    testEdit();
    category();

    function navigate(str) {
        if (/\/adminsc\/settings/.test(str)
            || /\/adminsc\/right\/list/.test(str)
            || /\/adminsc\/post\/list/.test(str) ||
            /\/adminsc\/todo\/list/.test(str)) {
            // rights()
            $("[settings]").addClass('current')


        } else if (/\/auth\/profile/.test(str)) {
            // user()
        } else if (/\/adminsc\/crm/.test(str)) {
            $("[crm]").addClass('current')


        } else if (/\/adminsc\/planning/.test(str)) {
            $("[plan]").addClass('current')

        } else if (
            /\/adminsc\/category/.test(str) ||
            /\/adminsc\/product/.test(str)
        ) {
            $("[catalog]").addClass('current')

        } else if (
            /\/test/.test(str)
            || /\/opentest/.test(str)
            || /\/adminsc\/opentest/.test(str)
            || /\/adminsc\/test/.test(str)) {
            $("[test]").addClass('current')

        } else {
            $("[href='/adminsc']").addClass('current')
        }

    }

});



