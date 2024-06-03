import '../components/header/Autocomplete/autocomplete'

import '../components/showPassword/showPassword'

import '../components/cookie/cookie'

import './changepassword'

import './register'
import './profile'
import './return_pass'
import './edit'
import './auth.scss'
// import './login'

import multiselect from '@components/multiselect/multiselect'
import catalogItem from '@components/catalog-item/catalog-item'

import radio from '@components/radio/radio'
import showPassword from "../components/showPassword/showPassword";
import {$} from "../common";


const loginForm = $("[data-auth='login']").first();
if (loginForm){
    const {default:Login} = await import('./login')
    new Login()
}

if ($('.modal-wrapper')){
    const {default:Modal} = await import("../components/Modal/modal")
    new Modal()
}



radio();

multiselect();
catalogItem();
showPassword();

