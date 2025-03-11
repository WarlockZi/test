import "../components/header/Autocomplete/autocomplete";
<<<<<<< HEAD

import "../components/showPassword/showPassword";

import "../components/cookie/cookie";

import "./changepassword";

=======
import "../components/showPassword/showPassword";
import "../components/cookie/cookie";
import "./changepassword";
>>>>>>> 34ae65b937a2b63dfa5b35d77ee96d0c5a192494
import "./register";
import "./profile";
import "./return_pass";
import "./edit";
import "./auth.scss";
<<<<<<< HEAD
import "./../../../pic/icons/arrowUp.svg";
// import './login'
=======

>>>>>>> 34ae65b937a2b63dfa5b35d77ee96d0c5a192494
import showPassword from "../components/showPassword/showPassword";
import { $ } from "../common";

const loginForm = $("[data-auth='login']").first();
if (loginForm) {
  const { default: Login } = await import("./login.js");
  new Login();
}

if ($(".modal").first()) {
  const { default: Modal } = await import("../components/Modal/modal.js");
  new Modal();
}
<<<<<<< HEAD
const f = 1;
=======
>>>>>>> 34ae65b937a2b63dfa5b35d77ee96d0c5a192494

showPassword();
