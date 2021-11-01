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
/* harmony import */ var _components_cookie_cookie__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../components/cookie/cookie */ "./public/src/components/cookie/cookie.js");
/* harmony import */ var _Auth_login_scss__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../Auth/login.scss */ "./public/src/Auth/login.scss");
/* harmony import */ var _cabinet_scss__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./cabinet.scss */ "./public/src/Auth/cabinet.scss");
/* harmony import */ var _components_footer_footer_scss__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ../components/footer/footer.scss */ "./public/src/components/footer/footer.scss");








(0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.form__button').on('submit', save);

function save(e) {
  let th = this;
  let form = formData;
}

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


(0,_common__WEBPACK_IMPORTED_MODULE_1__.$)("#save").on("click", async function (e) {
  e.preventDefault();
  let data = {
    // email: check_email(),
    name: (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('[name = "name"]').el[0].value,
    surName: (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('[name = "surName"]').el[0].value,
    middleName: (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('[name = "middleName"]').el[0].value,
    birthDate: (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('[name = "birthDate"]').el[0].value,
    phone: (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('[name = "phone"]').el[0].value
  };
  let res = await (0,_common__WEBPACK_IMPORTED_MODULE_1__.post)('/user/edit', data);

  if (res === 'ok') {
    _common__WEBPACK_IMPORTED_MODULE_1__.popup.show('Сохранено');
  }
}); // setTimeout(function () {
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


(0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('.password-control').on('click', function () {
  if ((0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('[name="password"]').attr('type') == 'password') {
    (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)(this).addClass('view');
    (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('[name="password"]').attr('type', 'text');
  } else {
    (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)(this).removeClass('view');
    (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('[name="password"]').attr('type', 'password');
  }

  return false;
});
let loginBtn = (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)("#login").el[0];

if (loginBtn) {
  (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)(loginBtn).on("click", async function (e) {
    e.preventDefault();
    let email = (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('input[type = email]').el[0].value;
    let password = (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('input[name = password]').el[0].value;

    if (!_common__WEBPACK_IMPORTED_MODULE_1__.validate.email(email)) {
      let $result = (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)(".message").el[0];
      $result.innerText = "Неправильный формат почты";
      (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)($result).addClass('error');
      return false;
    }

    if (!_common__WEBPACK_IMPORTED_MODULE_1__.validate.password(password)) {
      let $result = (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)(".message").el[0];
      $result.innerText = "Пароль может состоять из \n " + "- Большие латинские бкувы \n" + "- Маленькие латинские буквы \n" + "- Цифры \n" + "- Должен содержать не менее 6 символов";
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
  res = JSON.parse(res);
  let msg = (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('.message').el[0];

  if (res.msg === 'fail') {
    msg.innerHTML = 'Не верный email или пароль';
    (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)(msg).addClass('error');
    (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)(msg).removeClass('success');
  } else if (res.msg === 'not confirmed') {
    msg.innerHTML = "Зайдите на почту чтобы подтвердить регистрацию";
    (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)(msg).addClass('error');
    (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)(msg).removeClass('success');
  } else if (res.msg === 'ok') {
    window.location = '/user/cabinet';
  } else if (res.msg === 'not_registered') {
    msg.innerHTML = "email не зарегистрирован <br> Для регистрации перейдите в раздел <a href = '/user/register'>Регистрация</a>";
    (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)(msg).addClass('error');
    (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)(msg).removeClass('success');
  }
}

/***/ }),

/***/ "./public/src/Auth/register.js":
/*!*************************************!*\
  !*** ./public/src/Auth/register.js ***!
  \*************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _common__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../common */ "./public/src/common.js");

(0,_common__WEBPACK_IMPORTED_MODULE_0__.$)(".forgot").on("click", async function () {
  window.location.href = '/user/returnpass';
});
(0,_common__WEBPACK_IMPORTED_MODULE_0__.$)(".login").on("click", async function () {
  window.location.href = '/user/login';
});
(0,_common__WEBPACK_IMPORTED_MODULE_0__.$)(".reg").on("click", async function () {
  let email = (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('input[type = email]').el[0].value;
  let password = (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('input[type = password]').el[0].value;
  let msg = (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)(".message").el[0];

  if (!email || !password) {
    msg.innerText = "Заполните email и пароль";
    (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)(msg).addClass('error');
    return false;
  }

  if (email) {
    if (!_common__WEBPACK_IMPORTED_MODULE_0__.validate.email(email)) {
      msg.innerText = "Неправильный формат почты";
      (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)(msg).addClass('error');
      return false;
    }

    if (password) {
      if (!_common__WEBPACK_IMPORTED_MODULE_0__.validate.password(password)) {
        msg.innerText = "Пароль может состоять из \n " + "- больших латинских букв \n" + "- маленьких латинских букв \n" + "- цифр \n" + "- должен содержать не менее 6 символов";
        (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)(msg).addClass('error');
        return false;
      }
    }

    let res = await send(email);
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
    msg.el[0].innerHTML = '-Пользователь зарегистрирован.<br>' + '-Для подтверждения регистрации зайдите на почту, ' + '<bold>email</bold>.<br> ' + '-Перейдите по ссылке в письме.';
  } else if (res === 'mail exists') {
    msg.el[0].innerHTML = 'Эта почта уже зарегистрирована';
    msg.removeClass('success');
    msg.addClass('error');
  } else if (res === 'empty password') {
    msg.el[0].innerHTML = 'Зполните пароль';
    msg.removeClass('success');
    msg.addClass('error');
  } else {
    msg.el[0].innerHTML = res;
    msg.removeClass('success');
    msg.addClass('error');
  }
}

/***/ }),

/***/ "./public/src/Auth/return_pass.js":
/*!****************************************!*\
  !*** ./public/src/Auth/return_pass.js ***!
  \****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _common__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../common */ "./public/src/common.js");
/* harmony import */ var _components_popup_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../components/popup.scss */ "./public/src/components/popup.scss");


(0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.returnpass').on('click', async function (e) {
  let email = (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('input[type="email"]').el[0].value;
  let res = await (0,_common__WEBPACK_IMPORTED_MODULE_0__.post)('/user/returnpass', {
    email: email
  });
  res = await JSON.parse(res);

  if (res) {
    _common__WEBPACK_IMPORTED_MODULE_0__.popup.show(res.msg, function () {
      window.location = '/user/login';
    });
  }
});

/***/ }),

/***/ "./public/src/Test/model/test.js":
/*!***************************************!*\
  !*** ./public/src/Test/model/test.js ***!
  \***************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "_test": () => (/* binding */ _test)
/* harmony export */ });
/* harmony import */ var _common__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../common */ "./public/src/common.js");

let _test = {
  serverModel: () => {
    return {
      id: +window.location.href.split('/').pop(),
      test_name: (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('#test_name').text(),
      enable: +(0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('#enable').el[0].checked,
      isTest: +(0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('[isTest]').el[0].getAttribute('isTest'),
      parent: (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('select').selectedIndexValue()
    };
  },
  viewModel: () => {
    return {
      id: +window.location.href.split('/').pop(),
      test_name: (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('#test_name').text(),
      enable: (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('#enable').el[0],
      parent: (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('select').selectedIndexValue()
    };
  },
  id: id => {
    return id ?? (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.test-name').value();
  },
  children: () => {
    let arrChildren = (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.children').el;
    if (!arrChildren[0].innerText === 'не содержит') return arrChildren.length;
    return false;
  },
  path_create: async () => {
    let test_path = _test.serverModel();

    test_path.id = 0;
    test_path.isTest = 0;
    let url = `/test/create`;
    let res = await (0,_common__WEBPACK_IMPORTED_MODULE_0__.post)(url, test_path);
    res = await JSON.parse(res);

    if (res) {
      window.location.href = `/adminsc/test/edit/${res.id - 1}`;
    }
  },
  name: () => {
    return (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.test-name').el[0].innerText;
  },
  create: async () => {
    let test = _test.serverModel();

    test.id = 0;
    test.isTest = 1;
    let url = `/test/updateOrCreate`;
    let res = await (0,_common__WEBPACK_IMPORTED_MODULE_0__.post)(url, test);
    res = await JSON.parse(res);

    if (res) {
      window.location.href = `/adminsc/test/edit/${res.id - 1}`;
    }
  },
  update: async () => {
    let model = _test.serverModel();

    let url = `/adminsc/test/update/${model.id}`;
    let res = await (0,_common__WEBPACK_IMPORTED_MODULE_0__.post)(url, model);
    res = await JSON.parse(res);

    if (res) {
      window.location.href = `/adminsc/test/edit/${model.id}`;
    }
  },
  delete: async function () {
    if (_test.children()) {
      _common__WEBPACK_IMPORTED_MODULE_0__.popup.show('Сначала удалите все тесты из папки');
      return false;
    }

    let viewModel = _test.viewModel();

    viewModel.enable.checked = false;

    let serverModel = _test.serverModel();

    let res = await (0,_common__WEBPACK_IMPORTED_MODULE_0__.post)('/test/delete', {
      test: serverModel
    });
    res = await JSON.parse(res);

    if (res.notAdmin) {
      _common__WEBPACK_IMPORTED_MODULE_0__.popup.show('Видимость теста скрыта. Чтобы удалить полностью - обратитесь к ГД');
      setTimeout(() => {
        window.location = '/adminsc/test/edit/400';
      }, 4000);
    } else {
      window.location = '/adminsc/test/edit/400';
    }
  }
};

/***/ }),

/***/ "./public/src/common.js":
/*!******************************!*\
  !*** ./public/src/common.js ***!
  \******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "popup": () => (/* binding */ popup),
/* harmony export */   "test_delete_button": () => (/* binding */ test_delete_button),
/* harmony export */   "post": () => (/* binding */ post),
/* harmony export */   "get": () => (/* binding */ get),
/* harmony export */   "uniq": () => (/* binding */ uniq),
/* harmony export */   "validate": () => (/* binding */ validate),
/* harmony export */   "$": () => (/* binding */ $),
/* harmony export */   "fetchWrap": () => (/* binding */ fetchWrap),
/* harmony export */   "fetchW": () => (/* binding */ fetchW)
/* harmony export */ });
/* harmony import */ var _Test_model_test__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Test/model/test */ "./public/src/Test/model/test.js");

let validate = {
  sort: () => {
    let error = undefined.nextElementSibling;
    let ar = undefined.value.match(/\D+/);

    if (ar) {
      error.innerText = 'Только цифры';
      error.style.opacity = '1';
    } else {
      if (error.style.opacity === "1") {
        error.style.opacity = '0';
      }
    }
  },
  email: email => {
    if (!email) return false;
    let re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
  },
  password: password => {
    if (!password) return false;
    let re = /^[a-zA-Z\-0-9]{6,20}$/;
    return re.test(password);
  }
}; // function up() {
//    var top = Math.max(document.body.scrollTop, document.documentElement.scrollTop);
//    if (top > 0) {
//       window.scrollBy(0, -100);
//       var t = setTimeout('up()', 20);
//    }
//    else
//       clearTimeout(t);
//    return false;
// }

let popup = {
  show: function (txt, callback) {
    let close = this.el('div', 'popup__close');
    close.innerText = 'X';
    let popup__item = this.el('div', 'popup__item');
    popup__item.innerText = txt;
    popup__item.append(close);
    let popup = $('.popup').el[0];

    if (!popup) {
      popup = this.el('div', 'popup');
    }

    popup.append(popup__item);
    popup.addEventListener('click', this.close);
    document.body.append(popup);
    let hideDelay = 5000;
    setTimeout(() => {
      popup__item.classList.remove('popup__item');
      popup__item.classList.add('popup-hide');
    }, hideDelay);
    let removeDelay = hideDelay + 950;
    setTimeout(() => {
      popup__item.remove();

      if (callback) {
        callback();
      }
    }, removeDelay);
  },
  close: function (e) {
    if (e.target.classList.contains('popup__close')) {
      let popup = this.closest('.popup').remove();
    }
  },
  el: function (tagName, className) {
    let el = document.createElement(tagName);
    el.classList.add(className);
    return el;
  }
};

const uniq = array => Array.from(new Set(array));

async function get(key) {
  let p = window.location.search;
  p = p.match(new RegExp(key + '=([^&=]+)'));
  return p ? p[1] : false;
}

async function post(url, data = {}) {
  return new Promise(function (resolve, reject) {
    data.token = document.querySelector('meta[name="token"]').getAttribute('content');
    let req = new XMLHttpRequest();
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

    req.onload = async function () {
      resolve(req.response);
    };
  });
}

function MyJquery(elements) {
  this.el = elements;
  this.elType = {}.toString.call(elements);

  this.on = function (ev, f) {
    if (!this.el) return;

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

  this.attr = function (attrName, attrVal) {
    if (attrVal) {
      this.el[0].setAttribute(attrName, attrVal);
    }

    return this.el[0].getAttribute(attrName);
  };

  this.selectedIndexValue = function () {
    if (this.el.length) return this.el[0].selectedOptions[0].value;
  };

  this.options = function () {
    if (this.el.length) return this.el[0].options;
  };

  this.count = function () {
    return this.el.length;
  };

  this.text = function () {
    if (this.el.length) return this.el[0].innerText;
  };

  this.checked = function () {
    if (this.el.length) return this.el[0].checked;
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
    if (this.elType === "[object HTMLDivElement]") {
      this.el.classList.remove(className);
    }

    if (["[object NodeList]", "[object Array]"].includes(this.elType)) {
      this.el.forEach(s => {
        s.classList.remove(className);
      });
    }
  };

  this.hasClass = function (className) {
    if (this.el.classList.contains(className)) return true;
  };

  this.append = function (el) {
    this.el[0].appendChild(el);
  };

  this.find = function (selector) {
    if (["[object HTMLDivElement]", "[object HTMLInputElement]"].includes(this.elType)) {
      return this.el.querySelector(selector);
    }

    if (["[object NodeList]", "[object Array]"].includes(this.elType)) {
      return this.el[0].querySelector(selector);
    }
  };

  this.css = function (attr, val) {
    if (!val) {
      return this.el[0].style[attr];
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
  let elements = '';

  if (typeof selector === "string") {
    elements = document.querySelectorAll(selector);
  } else {
    elements = selector;
  }

  return new MyJquery(elements);
}

class test_delete_button {
  constructor(elem) {
    if (!elem) return;
    this._elem = $(elem).el[0];
    this._elem.onclick = this.delete;
    this._elem.onmouseenter = this.showToolip;
    this._elem.onmouseleave = this.hideTooltip;
    this._elem.onmousemove = this.changeTooltipPos;
  }

  async delete() {
    if (confirm('Удалить тест?')) {
      let res = test.del();

      if (res.msg === 'ok') {
        window.location = '/test/edit';
      }
    }
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

  hideTooltip() {
    this.tip.remove();
  }

  changeTooltipPos(e) {
    this.tip.style.top = e.pageY + 35 + 'px';
    this.tip.style.left = e.pageX - 170 + 'px';
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


[...(0,_common__WEBPACK_IMPORTED_MODULE_1__.$)(".search input").el].map(input => {
  if (input) {
    input.addEventListener('input', function () {
      autocomplete(input);
    });
  }
});

async function autocomplete(input) {
  let search = input.parentNode;
  let result = (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)(search).find('.search__result');

  if (input.value.length < 1) {
    if (result) result.innerHTML = '';
    return;
  }

  let data = await fetch('/search?q=' + input.value);
  data = await data.json(data);

  if (result.childNodes.length !== 0) {
    result.innerHTML = '';
  }

  data.map(e => {
    let a = document.createElement("a");
    a.href = e.alias;
    a.innerHTML = `<img src='/pic/${e.preview_pic}' alt='${e.name}'>` + e.name;
    result.appendChild(a);
  });
  (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('body').on('click', function (e) {
    if (result && e.target !== result) {
      result.innerHTML = '';
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
/* harmony import */ var _header_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./header.scss */ "./public/src/components/header/header.scss");



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

/***/ "./public/src/components/header/header.scss":
/*!**************************************************!*\
  !*** ./public/src/components/header/header.scss ***!
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

/***/ "./public/src/components/popup.scss":
/*!******************************************!*\
  !*** ./public/src/components/popup.scss ***!
  \******************************************/
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
/* harmony import */ var _components_forms_scss__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../components/forms.scss */ "./public/src/components/forms.scss");
/* harmony import */ var _components_cookie_cookie__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../components/cookie/cookie */ "./public/src/components/cookie/cookie.js");
/* harmony import */ var _components_footer_footer_scss__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../components/footer/footer.scss */ "./public/src/components/footer/footer.scss");
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