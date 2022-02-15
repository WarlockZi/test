import './admin.scss'
// import '../delete/main-menu/admin_main_menu'

import '../components/header/header-adm'
import '../components/accordion/accordion'

import testResults from '../Test/test_results/test_results'
import testEdit from '../Test/test-edit'
import testDo from '../Test/do'
import testUpdate from '../Test/test-update'
import settings from './Settings/settings'
import rights from './Rights/rights'
import planning from './Planning/planning'
import user from './CRM/user'


import "./model/cache";

import {$} from "../common";


navigate(window.location.pathname)

function navigate(str) {
  switch (true) {
    case /\/adminsc\/settings/.test(str):
    case /\/adminsc\/rights/.test(str):
      rights()
      $("[href='/adminsc/settings']").addClass('current')
      break;
    case /\/adminsc\/Sitemap/.test(str):
      settings()
      $("[href='/adminsc/settings']").addClass('current')
      break;

    case /\/adminsc\/crm\/testresults/.test(str):
      testResults()
      $("[href='/adminsc/crm/testresults']").addClass('current')
      break;

    case /\/adminsc\/crm\/user/.test(str):
      user()
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

    case /\/adminsc\/test\/update/.test(str):
      testUpdate()
      break;

    // case /\/adminsc\/test\/pathshow/.test(str):
    case /\/adminsc\/test\/edit/.test(str):
    case /\/adminsc\/test\/show/.test(str):
      testEdit()
      $("[href='/adminsc/test/edit']").addClass('current')
      break;

    case /\/test/.test(str)||/\/test\/result/.test(str):
      testDo()
      $("[href='/test/do']").addClass('current')
      break;

    default:
      $("[href='/']").addClass('current')
      break;
  }
}



