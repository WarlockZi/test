/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

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
  nextQ: () => {
    let current = _test.currentQ();

    if (current.id > current.navLength - 2) return false;

    let aimNavId = _test.aimNavIdFunction(current.id, 'next');

    let aimQEl = _test.aimQElFunction(current, 'next');

    _test.pushNav(current.id, aimNavId);

    _test.pushQ(current.QEl, aimQEl);
  },
  prevQ: () => {
    let current = _test.currentQ();

    if (current.id < 1) return false;

    let aimNavId = _test.aimNavIdFunction(current.id, 'back');

    let aimQEl = _test.aimQElFunction(current, 'back');

    _test.pushNav(current.id, aimNavId);

    _test.pushQ(current.QEl, aimQEl);
  },
  pushNav: (currentId, aimNavId) => {
    let currNavEl = (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('[data-pagination]').el[currentId];
    currNavEl.classList.toggle('nav-active');
    let NavEl = (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('[data-pagination]').el[aimNavId];
    NavEl.classList.toggle('nav-active');
  },
  pushQ: (currentEl, aimQEl) => {
    currentEl.classList.toggle('flex1');
    aimQEl.classList.toggle('flex1');
  },
  aimNavIdFunction: (currentId, direction) => {
    let dir = currentId;

    switch (true) {
      case direction === 'next':
        return dir += 1;
        break;

      case direction === 'back':
        return dir -= 1;
        break;
    }
  },
  aimQElFunction: (current, direction) => {
    switch (true) {
      case direction === 'next':
        return current.QNextEl;
        break;

      case direction === 'back':
        return current.QPrevc;
        break;
    }
  },
  currentQ: () => {
    return {
      id: (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.nav-active').el[0].innerText - 1,
      QEl: (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.question.flex1').el[0],
      navLength: (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('[data-pagination]').el.length,
      QPrevc: (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.question.flex1').el[0].previousElementSibling,
      QNextEl: (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.question.flex1').el[0].nextElementSibling
    };
  },
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
/* harmony export */   "navigate": () => (/* binding */ navigate),
/* harmony export */   "addTooltip": () => (/* binding */ addTooltip),
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
/* harmony import */ var _common_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./common.scss */ "./public/src/common.scss");


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

function addTooltip(args) {
  let ar = [...args.els];
  ar.map(el => {
    el.onmouseenter = function () {
      let tip = document.createElement('div');
      $(tip).addClass('tip');
      tip.innerText = args.message;
      el.append(tip);

      let remove = () => tip.remove();

      tip.addEventListener('mousemove', remove.bind(tip));
    }.bind(args);

    el.onmouseleave = () => {
      let tip = el.querySelector('.tip');
      tip.remove();
    };
  }, [args]);
}

function navigate(str) {
  switch (true) {
    case /\/adminsc\/test/.test(str):
      $('.module.test').addClass('activ');
      break;

    case /\/adminsc\/settings/.test(str):
    case /\/adminsc\/Sitemap/.test(str):
      $('.module.settings').addClass('activ');
      break;

    case /\/adminsc\/crm/.test(str):
      $('.module.crm').addClass('activ');
      break;

    case /\/adminsc\/catalog/.test(str):
      $('.module.catalog').addClass('activ');
      break;

    case /\/adminsc\/test/.test(str):
      $('.module.test').addClass('activ');
      break;

    default:
      $('.module.home').addClass('activ');
      break;
  }
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

/***/ "./public/src/Auth/login.scss":
/*!************************************!*\
  !*** ./public/src/Auth/login.scss ***!
  \************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./public/src/common.scss":
/*!********************************!*\
  !*** ./public/src/common.scss ***!
  \********************************/
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
/*!************************************!*\
  !*** ./public/src/Auth/cabinet.js ***!
  \************************************/
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
})();

/******/ })()
;
//# sourceMappingURL=cabinet.js.map