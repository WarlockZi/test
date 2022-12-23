import './admin.scss'
import './Videoinstructions/videoinstructions'

import '../components/header/header-adm'
import '../components/accordion/accordion'
import '../components/admin_sidebar'
import "./model/cache";
import "../components/date/date";
// import tiny from "../components/tiny/tiny";
import {$} from "../common";

import '../Test/test_results/test_results'
import '../Test/opentest-edit'
import testEdit from '../Test/test-edit'
import '../Test/do'
import './Settings/settings'
import rights from './Rights/rights'
import product from './Category/category1'
import category from './Product/product'
import './Planning/planning'
import user from './user/user'
import '../Test/open_test'
import './Category/category1'

import radio from '@components/radio/radio'
import multiselect from '@components/multiselect/multiselect'
import catalogItem from '@components/catalog-item/catalog-item'
import tooltips from "../components/tooltip/tooltip";
import accordionShow from "../components/accordion-show";
import Pagination from "../Test/test-pagination/test-pagination";
import quill from "../components/quill/quill";


$(document).ready(function () {

  navigate(window.location.pathname)
  radio()
  multiselect()
  catalogItem()
  tooltips()
  // tiny()
  quill()
  accordionShow()

  testEdit()
  product()
  category()

  function navigate(str) {
    if (/\/adminsc\/settings/.test(str)
      || /\/adminsc\/right\/list/.test(str)
      || /\/adminsc\/post\/list/.test(str) ||
      /\/adminsc\/todo\/list/.test(str)) {
      rights()
      $("[settings]").addClass('current')


    } else if (/\/auth\/profile/.test(str)) {
      user()
    } else if (/\/adminsc\/crm/.test(str)) {
      $("[crm]").addClass('current')


    } else if ( /\/adminsc\/planning/.test(str)) {
      $("[plan]").addClass('current')
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

})



