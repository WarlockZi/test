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

import showPassword from "../components/showPassword/showPassword";
import {$} from "../common";


const loginForm = $("[data-auth='login']").first();
if (loginForm){
    const {default:Login} = await import('./login.js')
    new Login()
}

if ($('.modal').first()){
    const {default:Modal} = await import("../components/Modal/modal.js")
    new Modal()
}
const f= 1

showPassword();

