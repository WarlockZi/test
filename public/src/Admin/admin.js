import './admin.scss'

import '../components/header/header-adm'
import '../components/accordion/accordion'
import "./model/cache";
import {$} from "../common";
import catalogItem from "../components/catalog-item/catalog-item";

import testResults from '../Test/test_results/test_results'
import testEdit from '../Test/test-edit'
import testDo from '../Test/do'
import testUpdate from '../Test/test-update'
import settings from './Settings/settings'
import rights from './Rights/rights'
import planning from './Planning/planning'
import user from './CRM/user/user'
import users from './CRM/user/users'

import list from '@components/list/list'

// let p = $('.page-name')[0]
navigate(window.location.pathname)
// debugger
catalogItem()
list()

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

    // case /\/adminsc\/[a-zA-Z0-9]+\/edit/.test(str):
    //
    //   list()


    case /\/adminsc\/test\/results/.test(str):
      // debugger
      testResults()
      $("[href='/adminsc/crm/testresults']").addClass('current')
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

    // case /\/adminsc\/test\/update/.test(str):
    // case /\/adminsc\/test\/show/.test(str):
    //   testUpdate()
    //   break;

    case /\/adminsc\/test\/pathshow/.test(str):
    case /\/adminsc\/test\/edit/.test(str):
      // debugger
      // testEdit()
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
      $("[href='/house']").addClass('current')
      break;
  }
}



