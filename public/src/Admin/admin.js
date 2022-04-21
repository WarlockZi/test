import './admin.scss'

import '../components/header/header-adm'
import '../components/accordion/accordion'
import "./model/cache";
import {$} from "../common";

import testResults from '../Test/test_results/test_results'
import testEdit from '../Test/test-edit'
import testDo from '../Test/do'
import settings from './Settings/settings'
import rights from './Rights/rights'
import planning from './Planning/planning'
import user from './user/user'
import users from './user/users'

import list from '@components/list/list'
import multiselect from '@components/multiselect/multiselect'
import catalogItem from '@components/catalog-item/catalog-item'

$(document).ready(function () {
  navigate(window.location.pathname)
// debugger

  list()
  multiselect()
  catalogItem()

  // debugger
  testEdit()

  function navigate(str) {
    // debugger
    switch (true) {
      case /\/adminsc\/settings/.test(str):
      case /\/adminsc\/right\/list/.test(str):
      case /\/adminsc\/post\/list/.test(str):
      case /\/adminsc\/todo\/list/.test(str):
        rights()
        $("[href='/adminsc/settings']").addClass('current')
        break;

      case /\/adminsc\/testresult\/results/.test(str):
        // debugger
        testResults()
        $("[href='/adminsc/test/results']").addClass('current')
        break;

      case /\/adminsc\/user/.test(str):
        user()
        break;

      case /\/adminsc\/user\/list/.test(str):
        users()
        break;

      case /\/adminsc\/crm/.test(str):
        $("[href='/adminsc/crm']").addClass('current')
        break;

      case /\/adminsc\/catalog/.test(str):
        $("[href='/adminsc/catalog']").addClass('current')
        break;

      case /\/adminsc\/planning/.test(str):
        planning()
        $("[href='/adminsc/planning']").addClass('current')
        break;

      case /\/adminsc\/test\/pathshow/.test(str):
      case /\/adminsc\/test\/edit/.test(str):
        $("[href='/adminsc/test/edit']").addClass('current')
        break;

      case /\/test/.test(str) || /\/test\/result/.test(str):
        testDo()
        $("[href='/test/do']").addClass('current')
        break;

      case /\/adminsc\/Sitemap/.test(str):
        settings()
        $("[href='/adminsc/settings']").addClass('current')
        break;

      default:
        $("[href='/adminsc']").addClass('current')
        break;
    }
  }

})



