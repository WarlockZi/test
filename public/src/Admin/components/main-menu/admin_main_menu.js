
import './admin_main_menu.scss'
import {$} from '../../../common'


function navigate(str) {
  switch (true) {
    case /\/adminsc\/test/.test(str):
      $('.module.test').addClass('activ')
      break;
    case /\/adminsc\/settings/.test(str):
    case /\/adminsc\/Sitemap/.test(str):
      $('.module.settings').addClass('activ')
      break;
    case /\/adminsc\/crm/.test(str):
      $('.module.crm').addClass('activ')
      break;
    case /\/adminsc\/catalog/.test(str):
      $('.module.catalog').addClass('activ')
      break;
    case /\/adminsc\/test/.test(str):
      $('.module.test').addClass('activ')
      break;
    default:
      $('.module.home').addClass('activ')
      break;
  }
}

navigate(window.location.pathname)
