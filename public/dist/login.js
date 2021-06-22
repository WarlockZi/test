/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./public/src/User/cabinet.js":
/*!************************************!*\
  !*** ./public/src/User/cabinet.js ***!
  \************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _common__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../common */ "./public/src/common.js");
/* harmony import */ var _components_header_header__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../components/header/header */ "./public/src/components/header/header.js");
/* harmony import */ var _normalize_scss__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../normalize.scss */ "./public/src/normalize.scss");
/* harmony import */ var _components_header_autocomplete__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../components/header/autocomplete */ "./public/src/components/header/autocomplete.js");
/* harmony import */ var _components_header_middle_sass__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../components/header/middle.sass */ "./public/src/components/header/middle.sass");
/* harmony import */ var _cabinet_scss__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./cabinet.scss */ "./public/src/User/cabinet.scss");
/* harmony import */ var _components_footer_footer_sass__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ../components/footer/footer.sass */ "./public/src/components/footer/footer.sass");








/***/ }),

/***/ "./public/src/User/register.js":
/*!*************************************!*\
  !*** ./public/src/User/register.js ***!
  \*************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _common__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../common */ "./public/src/common.js");

(0,_common__WEBPACK_IMPORTED_MODULE_0__.$)("[name = 'reg']").on("click", async function (e) {
  e.preventDefault();
  let email = (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('input[type = email]').el[0].value;
  if (!email) return false;
  let data = {
    "email": email,
    "password": (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)("input[type= password]").el[0].value,
    "surName": (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)("[name='surName']").el[0].value,
    "name": (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)("[name='name']").el[0].value,
    "token": (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('meta[name="token"]').el[0].getAttribute('content')
  };
  let res = await (0,_common__WEBPACK_IMPORTED_MODULE_0__.post)('/user/register', data);
  res = JSON.parse(res);

  if (res.msg === 'ok') {
    (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.message').addClass('success');
    (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.message').el[0].innerHTML = 'Зарегистрирован. Теперь, чтобы попасть в личный кабинет, необходимо зайти на почту, с которой производилась регистрация и перейти по ссылке для подтверждения почты.';
  } else if (res.msg === 'mail exists') {
    (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.message').addClass('error');
    (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.error').el[0].innerHTML = 'Почта уже зарегистрирована. Вам необходимо <a href="/user/login">ВОЙТИ</a>';
  } else {
    (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.error').el[0].innerHTML = res;
  }
});

/***/ }),

/***/ "./public/src/User/return_pass.js":
/*!****************************************!*\
  !*** ./public/src/User/return_pass.js ***!
  \****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _common__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../common */ "./public/src/common.js");

(0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.return_pass').on('click', async function (e) {
  e.preventDefault();

  if (e.target.classList.contains('submit')) {
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
  }
};

function get_cookie(cookie_name) {
  var results = document.cookie.match('(^|;)?' + cookie_name + '=([^;]*)');
  if (results) $('#cookie-notice').css({
    bottom: "-100%"
  }); // return (unescape(results[2]));
  else $('#cookie-notice').css({
      bottom: "0"
    });
  setCookie();
  return null;
}

function clearCache() {
  async function clearCache() {
    let response = await fetch('/adminsc/clearCache');
    let result = await response.text();
  }

  clearCache().catch(alert);
}

function setCookie() {
  const date = new Date(),
        minute = 60 * 1000,
        day = minute * 60 * 24;
  var days = 1;
  date.setTime(date.getTime() + days * day);
  $('#cookie-notice').css({
    bottom: "-100%"
  });
  document.cookie = "cn=1; expires=" + date + "path=/; SameSite=lax";
}

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
    req.open('POST', url, true); // req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    // req.setRequestHeader('Content-Type', 'multipart/form-data');

    req.setRequestHeader("X-Requested-With", "XMLHttpRequest");

    if (data instanceof FormData) {
      req.send(data);
    } else {
      // req.setRequestHeader('Content-Type', 'application/json');
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

/***/ "./public/src/components/header/autocomplete.js":
/*!******************************************************!*\
  !*** ./public/src/components/header/autocomplete.js ***!
  \******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _autocomplete_sass__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./autocomplete.sass */ "./public/src/components/header/autocomplete.sass");


window.onload = function () {
  let inp = document.querySelector('#autocomplete').addEventListener('input', function () {
    autocomplete(this.value);
  });
};

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
} // module.exports = autocomplete

/***/ }),

/***/ "./public/src/components/header/header.js":
/*!************************************************!*\
  !*** ./public/src/components/header/header.js ***!
  \************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _top_sass__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./top.sass */ "./public/src/components/header/top.sass");
/* harmony import */ var _middle_sass__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./middle.sass */ "./public/src/components/header/middle.sass");
/* harmony import */ var _header_menu_sass__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./header-menu.sass */ "./public/src/components/header/header-menu.sass");
/* harmony import */ var _header_sass__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./header.sass */ "./public/src/components/header/header.sass");
/* harmony import */ var _header_panel_sass__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./header-panel.sass */ "./public/src/components/header/header-panel.sass");






/***/ }),

/***/ "./public/src/User/cabinet.scss":
/*!**************************************!*\
  !*** ./public/src/User/cabinet.scss ***!
  \**************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./public/src/User/login.scss":
/*!************************************!*\
  !*** ./public/src/User/login.scss ***!
  \************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./public/src/components/footer/footer.sass":
/*!**************************************************!*\
  !*** ./public/src/components/footer/footer.sass ***!
  \**************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./public/src/components/forms.sass":
/*!******************************************!*\
  !*** ./public/src/components/forms.sass ***!
  \******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./public/src/components/header/autocomplete.sass":
/*!********************************************************!*\
  !*** ./public/src/components/header/autocomplete.sass ***!
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

/***/ "./public/src/components/header/middle.sass":
/*!**************************************************!*\
  !*** ./public/src/components/header/middle.sass ***!
  \**************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./public/src/components/header/top.sass":
/*!***********************************************!*\
  !*** ./public/src/components/header/top.sass ***!
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


/***/ }),

/***/ "./public/src/var.scss":
/*!*****************************!*\
  !*** ./public/src/var.scss ***!
  \*****************************/
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
/*!**********************************!*\
  !*** ./public/src/User/login.js ***!
  \**********************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _common__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../common */ "./public/src/common.js");
/* harmony import */ var _var_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../var.scss */ "./public/src/var.scss");
/* harmony import */ var _components_header_header__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../components/header/header */ "./public/src/components/header/header.js");
/* harmony import */ var _components_header_autocomplete__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../components/header/autocomplete */ "./public/src/components/header/autocomplete.js");
/* harmony import */ var _components_footer_footer_sass__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../components/footer/footer.sass */ "./public/src/components/footer/footer.sass");
/* harmony import */ var _components_forms_sass__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../components/forms.sass */ "./public/src/components/forms.sass");
/* harmony import */ var _login_scss__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./login.scss */ "./public/src/User/login.scss");
/* harmony import */ var _normalize_scss__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ../normalize.scss */ "./public/src/normalize.scss");
/* harmony import */ var _register__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ./register */ "./public/src/User/register.js");
/* harmony import */ var _cabinet__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! ./cabinet */ "./public/src/User/cabinet.js");
/* harmony import */ var _return_pass__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! ./return_pass */ "./public/src/User/return_pass.js");











(0,_common__WEBPACK_IMPORTED_MODULE_0__.$)("body").on("click", function (e) {
  if (e.target.className === "messageClose") {
    window.location.href = "/user/cabinet";
  }
});

if (typeof (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)("#login").el[0] !== 'undefined') {
  (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)("#login").on("click", async function (e) {
    e.preventDefault();
    var data = {
      "email": document.querySelector('input[type = email]').value,
      "password": document.querySelector("input[type= password]").value,
      "token": document.querySelector("[name = 'token']").getAttribute('content')
    };
    let res = await (0,_common__WEBPACK_IMPORTED_MODULE_0__.post)('/user/login', data);
    let overlayWrap = document.createElement('div');
    overlayWrap.innerHTML = res;
    document.body.append(overlayWrap);
    overlayWrap.querySelector('.overlay').style.display = "block";
  });
}
})();

/******/ })()
;
//# sourceMappingURL=login.js.map