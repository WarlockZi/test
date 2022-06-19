import './admin.scss'

import '../components/header/header-adm'
import '../components/accordion/accordion'
import '../components/admin_sidebar'
import "./model/cache";
import {$} from "../common";

import '../Test/test_results/test_results'
import '../Test/opentest-edit'
import testEdit from '../Test/test-edit'
import '../Test/do'
import './Settings/settings'
import rights from './Rights/rights'
import './Planning/planning'
import user from './user/user'
import '../Test/open_test'

import radio from '@components/radio/radio'
import list from '@components/list/list'
import multiselect from '@components/multiselect/multiselect'
import catalogItem from '@components/catalog-item/catalog-item'
import catalogDate from '@components/date/date'
import tooltips from "../components/tooltip/tooltip";
import accordionShow from "../components/accordion-show";

$(document).ready(function () {

  navigate(window.location.pathname)
  radio()
  list()
  multiselect()
  catalogItem()
  tooltips()

  accordionShow()

  testEdit()

  function navigate(str) {
    if (/\/adminsc\/settings/.test(str)
      || /\/adminsc\/right\/list/.test(str)
      || /\/adminsc\/post\/list/.test(str) ||
      /\/adminsc\/todo\/list/.test(str)) {
      rights()
      $("[href='/adminsc/settings']").addClass('current')
    } else if (/\/adminsc\/testresult\/results/.test(str)) {
      $("[href='/adminsc/test/results']").addClass('current')
    } else if (/\/adminsc\/testresult\/results/.test(str)) {
      $("[href='/adminsc/test/results']").addClass('current')
    } else if (/\/auth\/profile/.test(str)) {
      user()
    } else if (/\/adminsc\/crm/.test(str)) {
      $("[href='/adminsc/crm']").addClass('current')
    } else if (/\/adminsc\/catalog/.test(str)) {
      $("[href='/adminsc/catalog']").addClass('current')
    } else if (/\/adminsc\/planning/.test(str)) {
      $("[href='/adminsc/planning']").addClass('current')
    } else if (/\/adminsc\/test\/pathshow/.test(str)
      || /\/adminsc\/test\/edit/.test(str)) {
      $("[href='/adminsc/test/edit']").addClass('current')
    } else if (/\/test/.test(str) || /\/test\/result/.test(str)) {
      $("[href='/test/do']").addClass('current')
    } else if (/\/adminsc\/Sitemap/.test(str)) {
      $("[href='/adminsc/settings']").addClass('current')
    } else {
      $("[href='/adminsc']").addClass('current')
    }

  }

})



