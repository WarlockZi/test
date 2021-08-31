import {$} from '../common'

function navigate(str) {
    switch (true) {
        case /\/adminsc\/test\/edit/.test(str):
        case /\/test\/edit/.test(str):
            $('.module.test').addClass('activ')
            break;
        case /\/adminsc/.test(str):
            $('.module.home').addClass('activ')
            break;
        case /\/adminsc\/settings/:
        case /\/adminsc\/Sitemap/:
        case /\/adminsc\/setings\/pics/:
        case /\/adminsc\/settings\/prop/:
        case /\/adminsc\/settings\/props/:
            $('.module.settings').addClass('activ')
            break;
        case /\/adminsc\/crm/:
        case /\/adminsc\/crm\/users/:
            $('.module.crm').addClass('activ')
            break;
        case '/adminsc/catalog':
        case '/adminsc/catalog/category':
        case '/adminsc/catalog/product':
        case '/adminsc/catalog/products':
            $('.module.catalog').addClass('activ')
            break;
    }
}

navigate(window.location.pathname)
