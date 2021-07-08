/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./public/src/Auth/cabinet.js":
/*!************************************!*\
  !*** ./public/src/Auth/cabinet.js ***!
  \************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _common__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../common */ "./public/src/common.js");
/* harmony import */ var _components_header_header__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../components/header/header */ "./public/src/components/header/header.js");
/* harmony import */ var _normalize_scss__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../normalize.scss */ "./public/src/normalize.scss");
/* harmony import */ var _components_header_autocomplete__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../components/header/autocomplete */ "./public/src/components/header/autocomplete.js");
/* harmony import */ var _components_header_middle_scss__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../components/header/middle.scss */ "./public/src/components/header/middle.scss");
/* harmony import */ var _components_cookie_cookie__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../components/cookie/cookie */ "./public/src/components/cookie/cookie.js");
/* harmony import */ var _cabinet_scss__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./cabinet.scss */ "./public/src/Auth/cabinet.scss");
/* harmony import */ var _components_footer_footer_scss__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ../components/footer/footer.scss */ "./public/src/components/footer/footer.scss");









/***/ }),

/***/ "./public/src/Auth/changepassword.js":
/*!*******************************************!*\
  !*** ./public/src/Auth/changepassword.js ***!
  \*******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _common__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../common */ "./public/src/common.js");

(0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.changepassword').on('click', async function () {
  let res = await (0,_common__WEBPACK_IMPORTED_MODULE_0__.post)('/user/changepassword', {
    'old_password': (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('[name="old_password"]').el[0].value,
    'new_password': (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('[name="new_password"]').el[0].value
  });

  if (res === 'ok') {
    let msg = (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.message').el[0];
    msg.innerText = 'Пароль сменен';
    (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)(msg).addClass('success');
    (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)(msg).removeClass('error');
  } else {
    let msg = (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.message').el[0];
    msg.innerText = 'Что-то пошло не так';
    (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)(msg).addClass('error');
    (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)(msg).removeClass('success');
  }
});

/***/ }),

/***/ "./public/src/Auth/edit.js":
/*!*********************************!*\
  !*** ./public/src/Auth/edit.js ***!
  \*********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _edit_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./edit.scss */ "./public/src/Auth/edit.scss");
/* harmony import */ var _common__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../common */ "./public/src/common.js");


(0,_common__WEBPACK_IMPORTED_MODULE_1__.$)("[name = 'edit']").on("click", async function (e) {
  e.preventDefault();
  let data = {
    // email: check_email(),
    name: (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('[name = "name"]').el[0].value,
    surName: (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('[name = "surName"]').el[0].value,
    middleName: (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('[name = "middleName"]').el[0].value,
    birthDate: (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('[name = "birthDate"]').el[0].value,
    phone: (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('[name = "phone"]').el[0].value
  };
  let res = await (0,_common__WEBPACK_IMPORTED_MODULE_1__.post)('/user/edit', data); // if (res === 'ok'){

  debugger;
  _common__WEBPACK_IMPORTED_MODULE_1__.popup.show('Сохранено'); // }
}); //
// function check_email() {
//     let email = $('input[type = email]').el[0].value
//     if (!validate.email(email)) {
//         let $result = $(".message").el[0];
//         $result.innerText = "Неправильный формат почты"
//         $($result).addClass('error')
//         return false
//     }
//     return email
// }
// setTimeout(function () {
//     let p = document.querySelector("p.result");
//     p.parentNode.remove();
// }, 2000);

/***/ }),

/***/ "./public/src/Auth/login.js":
/*!**********************************!*\
  !*** ./public/src/Auth/login.js ***!
  \**********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _login_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./login.scss */ "./public/src/Auth/login.scss");
/* harmony import */ var _common__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../common */ "./public/src/common.js");


let loginBtn = (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)("#login").el[0];

if (loginBtn) {
  (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)(loginBtn).on("click", async function (e) {
    e.preventDefault();
    let email = (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('input[type = email]').el[0].value;
    let password = (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('input[type = password]').el[0].value;

    if (!_common__WEBPACK_IMPORTED_MODULE_1__.validate.email(email)) {
      let $result = (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)(".message").el[0];
      $result.innerText = "Неправильный формат почты";
      (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)($result).addClass('error');
      return false;
    }

    if (!_common__WEBPACK_IMPORTED_MODULE_1__.validate.password(password)) {
      let $result = (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)(".message").el[0];
      $result.innerText = "Пароль может состоять из \n " + "- Большие латинские бкувы \n" + "- Мальенькие латинские буквы \n" + "- Цифры \n" + "- должен содержать не менее 6 символов";
      (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)($result).addClass('error');
      return false;
    }

    send(email);
  });
}

async function send(email) {
  let res = await (0,_common__WEBPACK_IMPORTED_MODULE_1__.post)('/user/login', {
    "email": email,
    "password": (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)("input[type= password]").el[0].value
  });
  let msg = (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('.message').el[0];

  if (res === 'fail') {
    msg.innerHTML = 'Не верный email или пароль';
    (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)(msg).addClass('error');
    (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)(msg).removeClass('success');
  } else if (res === 'ok') {
    window.location = '/user/cabinet';
  } else if (res === 'not_registered') {
    msg.innerHTML = "Для регистрации перейдите в раздел <a href = '/user/register'>Регистрация</a>";
    (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)(msg).addClass('error');
    (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)(msg).removeClass('success');
  }
} //
// $("body").on("click",
//     function (e) {
//         if (e.target.className === "messageClose") {
//             window.location.href = "/user/cabinet";
//         }
//     })

/***/ }),

/***/ "./public/src/Auth/register.js":
/*!*************************************!*\
  !*** ./public/src/Auth/register.js ***!
  \*************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _common__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../common */ "./public/src/common.js");

(0,_common__WEBPACK_IMPORTED_MODULE_0__.$)("[name = 'reg']").on("click", async function (e) {
  e.preventDefault();
  let email = (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('input[type = email]').el[0].value;
  let password = (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('input[type = password]').el[0].value;

  if (email) {
    if (!_common__WEBPACK_IMPORTED_MODULE_0__.validate.email(email)) {
      let $result = (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)(".message").el[0];
      $result.innerText = "Неправильный формат почты";
      (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)($result).addClass('error');
      return false;
    }

    if (password) {
      if (!_common__WEBPACK_IMPORTED_MODULE_0__.validate.password(password)) {
        let msg = (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)(".message").el[0];
        msg.innerText = "Пароль может состоять из \n " + "- больших латинских букв \n" + "- маленьких латинских букв \n" + "- цифр \n" + "- должен содержать не менее 6 символов";
        (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)(msg).addClass('error');
        return false;
      }
    }

    send(email);
  }
});

async function send(email) {
  let data = {
    "email": email,
    "password": (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)("input[type= password]").el[0].value,
    "surName": (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)("[name='surName']").el[0].value,
    "name": (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)("[name='name']").el[0].value,
    "token": (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('meta[name="token"]').el[0].getAttribute('content')
  };
  let res = await (0,_common__WEBPACK_IMPORTED_MODULE_0__.post)('/user/register', data);
  let msg = (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.message');

  if (res === 'confirm') {
    msg.removeClass('error');
    msg.addClass('success');
    msg.el[0].innerHTML = 'Пользователь зарегистрирован.<br>' + 'Для подтверждения регистрации зайдите на почту, ' + 'с которой производилась регистрация.<br> ' + 'Перейдите по ссылке в письме.'; // window.location='/user/cabinet'
  } else if (res === 'mail exists') {
    msg.el[0].innerHTML = 'Эта почта уже зарегистрирована';
    msg.removeClass('success');
    msg.addClass('error');
  } else if (res === 'empty password') {
    msg.el[0].innerHTML = 'Зполните пароль';
    msg.removeClass('success');
    msg.addClass('error');
  } // else if(res==='confirm'){
  //     msg.el[0].innerHTML = "Для подтвержения регистрации перейдите по ссылке в письме. <br>Письмо может попасть в папку СПАМ"
  //     msg.removeClass('error')
  //     msg.addClass('success')
  // }

}

/***/ }),

/***/ "./public/src/Auth/return_pass.js":
/*!****************************************!*\
  !*** ./public/src/Auth/return_pass.js ***!
  \****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _common__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../common */ "./public/src/common.js");

(0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.return_pass').on('click', async function (e) {
  e.preventDefault();

  if (e.target.classList.contains('returnpass')) {
    let email = (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('input[type="email"]').el[0].value;
    let res = await (0,_common__WEBPACK_IMPORTED_MODULE_0__.post)('/user/returnPass', {
      email: email
    });

    if (res === 'ok') {
      window.location = '/user/login';
    }
  }
});

/***/ }),

/***/ "./public/src/common.js":
/*!******************************!*\
  !*** ./public/src/common.js ***!
  \******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "popup": () => (/* binding */ popup),
/* harmony export */   "test_delete": () => (/* binding */ test_delete),
/* harmony export */   "post": () => (/* binding */ post),
/* harmony export */   "get": () => (/* binding */ get),
/* harmony export */   "uniq": () => (/* binding */ uniq),
/* harmony export */   "validate": () => (/* binding */ validate),
/* harmony export */   "$": () => (/* binding */ $),
/* harmony export */   "fetchWrap": () => (/* binding */ fetchWrap),
/* harmony export */   "fetchW": () => (/* binding */ fetchW)
/* harmony export */ });
let validate = {
  sort: function (s) {
    let error = this.nextElementSibling;
    let ar = this.value.match(/\D+/);

    if (ar) {
      error.innerText = 'Только цифры';
      error.style.opacity = '1';
    } else {
      if (error.style.opacity === "1") {
        error.style.opacity = '0';
      }
    }
  },
  email: function (email) {
    const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if (!email) return false;

    if (!re.test(email)) {
      return false;
    }

    return true;
  },
  password: function (password) {
    const re = /^[a-zA-Z\-0-9]{6,20}$/;
    if (!password) return false;

    if (!re.test(password)) {
      return false;
    }

    return true;
  }
};

function clearCache() {
  async function clearCache() {
    let response = await fetch('/adminsc/clearCache');
    let result = await response.text();
  }

  clearCache().catch(alert);
}

let popup = {
  show: function (txt) {
    let close = document.createElement('div');
    close.classList.add('close');
    let popup = document.createElement('div');
    close.classList.add('popup');
    popup.innerText = txt;
    popup.append(close);
    let wrapper = document.createElement('div');
    wrapper.classList.add('popup__wrapper');
    wrapper.append(popup);
    popup.addEventListener('click', this.close);
    document.body.append(wrapper);
  },
  close: function (e) {
    if (e.target.classList.contains('close')) {}
  }
};

const uniq = array => Array.from(new Set(array));

async function get(key) {
  var p = window.location.search;
  p = p.match(new RegExp(key + '=([^&=]+)'));
  return p ? p[1] : false;
}

async function post(url, data) {
  //      debugger;
  return new Promise(function (resolve, reject) {
    data.token = document.querySelector('meta[name="token"]').getAttribute('content');
    var req = new XMLHttpRequest();
    req.open('POST', url, true);
    req.setRequestHeader("X-Requested-With", "XMLHttpRequest");

    if (data instanceof FormData) {
      req.send(data);
    } else {
      req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      req.send('param=' + JSON.stringify(data));
    }

    req.onerror = function () {
      reject(Error("Network Error"));
    };

    req.onload = function () {
      resolve(req.response);
    };
  });
}

function MyJquery(elements) {
  this.el = elements;
  this.elType = {}.toString.call(elements);

  this.on = function (ev, f) {
    if (this.elType === "[object HTMLDivElement]") {
      this.el.addEventListener(ev, f);
    }

    if (this.elType === "[object NodeList]") {
      elements.forEach(s => s.addEventListener(ev, f));
    }
  };

  this.value = function () {
    return this.el[0].getAttribute('value');
  };

  this.count = function () {
    return this.el.length;
  };

  this.getWithStyle = function (attr, val) {
    let arr = [];
    elements.forEach(s => {
      if (s.style[attr] === val) {
        arr.push(s);
      }
    });
    return arr;
  };

  this.addClass = function (className) {
    if (this.elType === "[object HTMLDivElement]") {
      this.el.classList.add(className);
    }

    if (["[object NodeList]", "[object Array]"].includes(this.elType)) {
      this.el.forEach(s => {
        s.classList.add(className);
      });
    }
  };

  this.removeClass = function (className) {
    this.el.forEach(s => {
      s.classList.remove(className);
    });
  };

  this.hasClass = function (className) {
    if (this.el.classList.contains(className)) return true;
  };

  this.append = function (el) {
    this.el[0].appendChild(el);
  };

  this.find = function (selector) {
    if (this.elType === "[object HTMLDivElement]") {
      return this.el.querySelector(selector);
    }

    if (["[object NodeList]", "[object Array]"].includes(this.elType)) {
      return this.el[0].querySelector(selector);
    }
  };

  this.css = function (attr, val) {
    if (!val) {
      return el.style[attr];
    }

    if (this.elType === "[object HTMLDivElement]") {
      this.el.style[attr] = val;
    }

    if (this.elType === "[object NodeList]") {
      elements.forEach(s => {
        s.style[attr] = val;
      });
    }
  };
}

function $(selector) {
  let elements = [];

  if (typeof selector === "string") {
    elements = document.querySelectorAll(selector);
  } else {
    elements = selector;
  }

  return new MyJquery(elements);
}

class test_delete {
  constructor(elem) {
    this._elem = elem;
    elem.onclick = this.onClick.bind(this); // (*)

    elem.onmouseenter = this.showToolip;
    elem.onmouseleave = this.hideTooltip;
    elem.onmousemove = this.changeTooltipPos;
  }

  async delete() {
    if (confirm('Удалить тест?')) {
      let id = $('.test-name').value();
      let res = await post('/test/delete', {
        id: id
      });

      if (res.msg === 'ok') {
        window.location.reload();
      }
    }
  }

  changeTooltipPos(e) {
    this.tip.style.top = e.pageY + 35 + 'px';
    this.tip.style.left = e.pageX - 170 + 'px';
  }

  hideTooltip() {
    this.tip.remove();
  }

  showToolip(e) {
    let x = e.clientX;
    let y = e.clientY;
    let tip = document.createElement('div');
    $(tip).addClass('tip');
    tip.style.top = y + 70 + 'px';
    tip.style.left = x - 170 + 'px';
    tip.innerText = this.getAttribute('tip');
    this.tip = tip;
    document.body.append(tip);
  }

  onClick(event) {
    let action = event.target.closest('.test_delete').dataset['click'];

    if (action) {
      this[action]();
    }
  }

}

async function fetchWrap(Obj, file) {
  let data = new FormData();
  data.append('ajax', true);
  data.append('param', JSON.stringify(Obj));
  file ? data.append('file', file) : '';
  let prom = await fetch(`/adminsc`, {
    body: data,
    method: 'post'
  });
  return prom.text();
}

async function fetchW(url, Obj) {
  let prom = await fetch(url, {
    body: 'param=' + JSON.stringify(Obj),
    method: 'post',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
      'HTTP_X_REQUESTED_WITH': 'XMLHttpRequest'
    }
  });
  return prom;
}



/***/ }),

/***/ "./public/src/components/alert/alert.js":
/*!**********************************************!*\
  !*** ./public/src/components/alert/alert.js ***!
  \**********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _alert_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./alert.scss */ "./public/src/components/alert/alert.scss");
/* harmony import */ var _common__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../common */ "./public/src/common.js");


(0,_common__WEBPACK_IMPORTED_MODULE_1__.$)("body").on("click", function (e) {
  if (e.target.className === "messageClose") {
    // alert(e.target.className)
    window.location.href = "/user/cabinet";
  }
});

/***/ }),

/***/ "./public/src/components/cookie/cookie.js":
/*!************************************************!*\
  !*** ./public/src/components/cookie/cookie.js ***!
  \************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _cookie_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./cookie.scss */ "./public/src/components/cookie/cookie.scss");
/* harmony import */ var _common__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../common */ "./public/src/common.js");


check_cookie('cn');

function check_cookie(cookie_name) {
  if (getCookie(cookie_name)) (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('#cookie-notice').css('bottom', '-100%');else (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('#cookie-notice').css('bottom', "0");
}

function getCookie(cookie_name) {
  return document.cookie.match('(^|;)?' + cookie_name + '=([^;]*)');
}

(0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('#cn-accept-cookie').on('click', clicked);

function clicked() {
  setCookie();
  (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('#cookie-notice').css('bottom', '-100%');
}

function setCookie() {
  const date = new Date(),
        minute = 60 * 1000,
        day = minute * 60 * 24;
  let days = 1;
  date.setTime(date.getTime() + days * day);
  document.cookie = "cn=1; expires=" + date + "path=/; SameSite=lax";
}

/***/ }),

/***/ "./public/src/components/header/autocomplete.js":
/*!******************************************************!*\
  !*** ./public/src/components/header/autocomplete.js ***!
  \******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _autocomplete_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./autocomplete.scss */ "./public/src/components/header/autocomplete.scss");
/* harmony import */ var _common__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../common */ "./public/src/common.js");


let inp = (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('#autocomplete').el[0];

if (inp) {
  inp.addEventListener('input', function () {
    autocomplete(this.value);
  });
}

async function fetchJson(Input) {
  let response = await fetch('/search?q=' + Input);
  return await response.json();
}

async function autocomplete(val) {
  if (val.length < 1) {
    result.innerHTML = '';
    return;
  }

  var data = await fetchJson(val);
  debugger;
  var res = '<ul>';
  data.forEach(e => {
    res += '<li>' + `<a href = '${e.alias}'>` + `<img src='/pic/${e.preview_pic}' alt='${e.name}'>` + e.name + '</a></li>';
  });
  res += '</ul>';
  var result = document.querySelector('.result-search');
  result.innerHTML = res;
  document.querySelector('body').addEventListener('click', function (e) {
    const search = document.querySelector('.result-search ul');

    if (document.querySelector('.result-search ul') && e.target !== search) {
      search.remove();
    }
  });
}

/***/ }),

/***/ "./public/src/components/header/header.js":
/*!************************************************!*\
  !*** ./public/src/components/header/header.js ***!
  \************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _top_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./top.scss */ "./public/src/components/header/top.scss");
/* harmony import */ var _middle_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./middle.scss */ "./public/src/components/header/middle.scss");
/* harmony import */ var _header_menu_sass__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./header-menu.sass */ "./public/src/components/header/header-menu.sass");
/* harmony import */ var _header_sass__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./header.sass */ "./public/src/components/header/header.sass");
/* harmony import */ var _header_panel_sass__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./header-panel.sass */ "./public/src/components/header/header-panel.sass");






/***/ }),

/***/ "./public/src/Auth/cabinet.scss":
/*!**************************************!*\
  !*** ./public/src/Auth/cabinet.scss ***!
  \**************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./public/src/Auth/edit.scss":
/*!***********************************!*\
  !*** ./public/src/Auth/edit.scss ***!
  \***********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./public/src/Auth/login.scss":
/*!************************************!*\
  !*** ./public/src/Auth/login.scss ***!
  \************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./public/src/components/alert/alert.scss":
/*!************************************************!*\
  !*** ./public/src/components/alert/alert.scss ***!
  \************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./public/src/components/cookie/cookie.scss":
/*!**************************************************!*\
  !*** ./public/src/components/cookie/cookie.scss ***!
  \**************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./public/src/components/footer/footer.scss":
/*!**************************************************!*\
  !*** ./public/src/components/footer/footer.scss ***!
  \**************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./public/src/components/forms.scss":
/*!******************************************!*\
  !*** ./public/src/components/forms.scss ***!
  \******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./public/src/components/header/autocomplete.scss":
/*!********************************************************!*\
  !*** ./public/src/components/header/autocomplete.scss ***!
  \********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./public/src/components/header/header-menu.sass":
/*!*******************************************************!*\
  !*** ./public/src/components/header/header-menu.sass ***!
  \*******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./public/src/components/header/header-panel.sass":
/*!********************************************************!*\
  !*** ./public/src/components/header/header-panel.sass ***!
  \********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./public/src/components/header/header.sass":
/*!**************************************************!*\
  !*** ./public/src/components/header/header.sass ***!
  \**************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./public/src/components/header/middle.scss":
/*!**************************************************!*\
  !*** ./public/src/components/header/middle.scss ***!
  \**************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./public/src/components/header/top.scss":
/*!***********************************************!*\
  !*** ./public/src/components/header/top.scss ***!
  \***********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./public/src/normalize.scss":
/*!***********************************!*\
  !*** ./public/src/normalize.scss ***!
  \***********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
(() => {
/*!*********************************!*\
  !*** ./public/src/Auth/auth.js ***!
  \*********************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _components_header_header__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../components/header/header */ "./public/src/components/header/header.js");
/* harmony import */ var _components_header_autocomplete__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../components/header/autocomplete */ "./public/src/components/header/autocomplete.js");
/* harmony import */ var _components_alert_alert__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../components/alert/alert */ "./public/src/components/alert/alert.js");
/* harmony import */ var _components_footer_footer_scss__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../components/footer/footer.scss */ "./public/src/components/footer/footer.scss");
/* harmony import */ var _components_forms_scss__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../components/forms.scss */ "./public/src/components/forms.scss");
/* harmony import */ var _components_cookie_cookie__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../components/cookie/cookie */ "./public/src/components/cookie/cookie.js");
/* harmony import */ var _changepassword__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./changepassword */ "./public/src/Auth/changepassword.js");
/* harmony import */ var _login__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./login */ "./public/src/Auth/login.js");
/* harmony import */ var _register__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ./register */ "./public/src/Auth/register.js");
/* harmony import */ var _cabinet__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! ./cabinet */ "./public/src/Auth/cabinet.js");
/* harmony import */ var _return_pass__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! ./return_pass */ "./public/src/Auth/return_pass.js");
/* harmony import */ var _edit__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! ./edit */ "./public/src/Auth/edit.js");












})();

/******/ })()
;
//# sourceMappingURL=auth.js.map