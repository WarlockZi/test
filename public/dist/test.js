/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./public/src/Test/do.js":
/*!*******************************!*\
  !*** ./public/src/Test/do.js ***!
  \*******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _common__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../common */ "./public/src/common.js");
/* harmony import */ var _do_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./do.scss */ "./public/src/Test/do.scss");
/* harmony import */ var _components_header_autocomplete__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../components/header/autocomplete */ "./public/src/components/header/autocomplete.js");
/* harmony import */ var _components_cookie_cookie__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../components/cookie/cookie */ "./public/src/components/cookie/cookie.js");



 //Скрыть все вопросы

(0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.question').removeClass("flex1"); //Показть первый вопрос

(0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.question:first-child').addClass("flex1");
(0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('[type="checkbox"]').on('click', function (e) {
  let a = e.target.labels[0];
  a.classList.toggle('pushed');
}); /////////////////////////////////////////////////////////////////////////////
///////////  RESULTS  TEST  Закончить тест/////////////////////////////
/////////////////////////////////////////////////////////////////////////////

(0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.content').on('click', async function (e) {
  let button = e.target;

  if (button.id === 'btnn') {
    if (button.text == "ПРОЙТИ ТЕСТ ЗАНОВО") {
      location.reload();
      return;
    }

    let corrAnswers = await (0,_common__WEBPACK_IMPORTED_MODULE_0__.post)('/test/getCorrectAnswers', {});
    corrAnswers = JSON.parse(corrAnswers);
    let errorCnt = colorView(corrAnswers);
    let data = objToServer(errorCnt);
    let res = await (0,_common__WEBPACK_IMPORTED_MODULE_0__.post)('/test/cachePageSendEmail', data);

    if (res) {
      (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)("#btnn").el[0].href = location.href; //"?test="+testId

      (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)("#btnn").el[0].text = "ПРОЙТИ ТЕСТ ЗАНОВО"; //"?test="+testId
    }
  }
});

function colorView(correctAnswers) {
  let q = (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.question').el;
  Array.from(q).map((question, i) => {
    let answers = question.querySelectorAll('.a'),
        errors = [];
    Array.from(answers).map(answer => {
      let input = answer.getElementsByTagName('input')[0],
          answerId = input.id.replace("answer-", ""),
          // id question
      label = answer.getElementsByTagName('label')[0],
          // Чтобы прикрепить зеленый значек к этому элементу
      correctAnser = correctAnswers.indexOf(answerId) !== -1;

      if (!checkCorrectAnswers(correctAnser, input, label)) {
        errors.push(true);
      }
    });
    let questId = +question.dataset['id'],
        // id question
    paginItem = (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.pagination [data-pagination="' + questId + '"]').el[0];

    if (errors.length) {
      (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)(paginItem).addClass('redShadow');
    } else {
      (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)(paginItem).addClass('greenShadow');
    }
  });
  return (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.redShadow').el.length;
}

function checkCorrectAnswers(correctAnser, input, label) {
  if (input.checked && correctAnser) {
    // checkbox нажат. а в correct answer нету. в correct_answers есть, его всегда подсвечиваем зеленым
    label.classList.add('done'); //green check зеленый значек

    return true;
  } else if (input.checked && !correctAnser) {
    // checkbox нажат,и есть в correct answer. в correct_answers нет, кнопка не нажата
    return false;
  } else if (!input.checked && correctAnser) {
    // кнопка не нажата, в correct_answers есть
    label.classList.add('done'); //green check зеленый значек

    label.classList.add('done'); // green check зеленый значек

    return false;
  } else if (!input.checked && !correctAnser) {
    // кнопка не нажата, в correct_answers нет
    return true;
  }
}

function objToServer(errorCnt) {
  return {
    token: document.querySelector('meta[name="token"]').getAttribute('content'),
    questionCnt: (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.question').el.length,
    errorCnt: errorCnt,
    pageCache: `<!DOCTYPE ${document.doctype.name}>` + document.documentElement.outerHTML,
    testId: (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('[data-test-id]').el[0].dataset.testId,
    test_name: (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.test-name').el[0].innerText,
    userName: (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.user-menu__FIO').el[0].innerText
  };
}

/***/ }),

/***/ "./public/src/Test/model/question.js":
/*!*******************************************!*\
  !*** ./public/src/Test/model/question.js ***!
  \*******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "_question": () => (/* binding */ _question)
/* harmony export */ });
/* harmony import */ var _common__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../common */ "./public/src/common.js");
/* harmony import */ var _components_test_pagination_test_pagination__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../components/test-pagination/test-pagination */ "./public/src/components/test-pagination/test-pagination.js");



function _question(id) {
  let q = id ? (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)(`.e-block-q#{id}`).el[0] : (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.block.flex1 .e-block-q').el[0];
  return new question(q);
}

function question(q) {
  this.q = q;

  this.add = function () {};

  this.delete = async function () {
    if (confirm("Удалить вопрос со всеми его ответами?")) {
      let q_id = +this.q.id;
      let res = await (0,_common__WEBPACK_IMPORTED_MODULE_0__.post)('/question/delete', {
        q_id
      });
      return JSON.parse(res);
    }
  };

  this.save = async function () {
    let res = await (0,_common__WEBPACK_IMPORTED_MODULE_0__.post)('/question/UpdateOrCreate', {
      question: this.get(),
      answers: this.getAnswers()
    });
    return await JSON.parse(res);
  };

  this.getAnswers = function () {
    let answerBlocks = (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.block.flex1 .e-block-a').el;
    return [...answerBlocks].map(a => {
      return {
        id: +a.querySelector('.checkbox').dataset['answer'],
        answer: a.querySelector('textarea').value,
        correct_answer: +a.querySelector('.checkbox').checked,
        parent_question: +this.q.id,
        pica: ''
      };
    }, this.q);
  };

  this.get = function () {
    return {
      id: +this.q.id,
      parent: +(0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.test-name').el[0].getAttribute('value'),
      picq: '',
      qustion: (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)(this.q).find('textarea').value,
      sort: +(0,_common__WEBPACK_IMPORTED_MODULE_0__.$)(this.q).find('.question__sort').value
    };
  };
}



/***/ }),

/***/ "./public/src/Test/model/test.js":
/*!***************************************!*\
  !*** ./public/src/Test/model/test.js ***!
  \***************************************/
/***/ (() => {

throw new Error("Module build failed (from ./node_modules/babel-loader/lib/index.js):\nSyntaxError: C:\\OpenServer\\domains\\vi-production\\public\\src\\Test\\model\\test.js: Unexpected keyword 'this'. (5:24)\n\n\u001b[0m \u001b[90m 3 |\u001b[39m     id\u001b[33m:\u001b[39m$(\u001b[32m'.test-name'\u001b[39m)\u001b[33m.\u001b[39mvalue()\u001b[33m,\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m 4 |\u001b[39m     name\u001b[33m:\u001b[39m$(\u001b[32m'.test-name'\u001b[39m)\u001b[33m.\u001b[39mel[\u001b[35m0\u001b[39m]\u001b[33m.\u001b[39minnerText\u001b[33m,\u001b[39m\u001b[0m\n\u001b[0m\u001b[31m\u001b[1m>\u001b[22m\u001b[39m\u001b[90m 5 |\u001b[39m     del\u001b[33m:\u001b[39m \u001b[36masync\u001b[39m \u001b[36mfunction\u001b[39m(\u001b[36mthis\u001b[39m\u001b[33m.\u001b[39mid){\u001b[0m\n\u001b[0m \u001b[90m   |\u001b[39m                         \u001b[31m\u001b[1m^\u001b[22m\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m 6 |\u001b[39m         \u001b[36mawait\u001b[39m post(\u001b[32m'/test/delete'\u001b[39m\u001b[33m,\u001b[39m{id})\u001b[0m\n\u001b[0m \u001b[90m 7 |\u001b[39m         \u001b[36mreturn\u001b[39m \u001b[33mJSON\u001b[39m\u001b[33m.\u001b[39mparse(res)\u001b[0m\n\u001b[0m \u001b[90m 8 |\u001b[39m     }\u001b[33m,\u001b[39m\u001b[0m\n    at Parser._raise (C:\\OpenServer\\domains\\vi-production\\node_modules\\@babel\\core\\node_modules\\@babel\\parser\\lib\\index.js:810:17)\n    at Parser.raiseWithData (C:\\OpenServer\\domains\\vi-production\\node_modules\\@babel\\core\\node_modules\\@babel\\parser\\lib\\index.js:803:17)\n    at Parser.raise (C:\\OpenServer\\domains\\vi-production\\node_modules\\@babel\\core\\node_modules\\@babel\\parser\\lib\\index.js:764:17)\n    at Parser.checkReservedWord (C:\\OpenServer\\domains\\vi-production\\node_modules\\@babel\\core\\node_modules\\@babel\\parser\\lib\\index.js:12188:12)\n    at Parser.parseIdentifierName (C:\\OpenServer\\domains\\vi-production\\node_modules\\@babel\\core\\node_modules\\@babel\\parser\\lib\\index.js:12157:12)\n    at Parser.parseIdentifier (C:\\OpenServer\\domains\\vi-production\\node_modules\\@babel\\core\\node_modules\\@babel\\parser\\lib\\index.js:12124:23)\n    at Parser.parseBindingAtom (C:\\OpenServer\\domains\\vi-production\\node_modules\\@babel\\core\\node_modules\\@babel\\parser\\lib\\index.js:10398:17)\n    at Parser.parseMaybeDefault (C:\\OpenServer\\domains\\vi-production\\node_modules\\@babel\\core\\node_modules\\@babel\\parser\\lib\\index.js:10460:50)\n    at Parser.parseAssignableListItem (C:\\OpenServer\\domains\\vi-production\\node_modules\\@babel\\core\\node_modules\\@babel\\parser\\lib\\index.js:10440:23)\n    at Parser.parseBindingList (C:\\OpenServer\\domains\\vi-production\\node_modules\\@babel\\core\\node_modules\\@babel\\parser\\lib\\index.js:10432:24)");

/***/ }),

/***/ "./public/src/Test/show.js":
/*!*********************************!*\
  !*** ./public/src/Test/show.js ***!
  \*********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _show_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./show.scss */ "./public/src/Test/show.scss");
/* harmony import */ var _common__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../common */ "./public/src/common.js");


(0,_common__WEBPACK_IMPORTED_MODULE_1__.$)(".save-test").on('click', async function () {
  let test_name = (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('#test_name').el[0].innerText;
  let enable = 1;
  let sel = (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('select').el[0];
  let isTest = +!(0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('#isPath').el[0].checked;
  let sort = 0;
  let parent = sel.options[sel.selectedIndex].value;
  let res = await (0,_common__WEBPACK_IMPORTED_MODULE_1__.post)('/test/create', {
    test_name,
    enable,
    isTest,
    sort,
    parent
  });
  res = await JSON.parse(res);

  if (res) {
    window.location.href = `/adminsc/test/edit/${res.id}` + '?id=' + res.id + '&name=' + test_name;
  }
});

/***/ }),

/***/ "./public/src/Test/test-edit.js":
/*!**************************************!*\
  !*** ./public/src/Test/test-edit.js ***!
  \**************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "aDelete": () => (/* binding */ aDelete),
/* harmony export */   "aAdd": () => (/* binding */ aAdd)
/* harmony export */ });
/* harmony import */ var _normalize_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../normalize.scss */ "./public/src/normalize.scss");
/* harmony import */ var _components_test_pagination_test_pagination__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../components/test-pagination/test-pagination */ "./public/src/components/test-pagination/test-pagination.js");
/* harmony import */ var _components_header_header__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../components/header/header */ "./public/src/components/header/header.js");
/* harmony import */ var _components_footer_footer_scss__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../components/footer/footer.scss */ "./public/src/components/footer/footer.scss");
/* harmony import */ var _test_edit_scss__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./test-edit.scss */ "./public/src/Test/test-edit.scss");
/* harmony import */ var _show__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./show */ "./public/src/Test/show.js");
/* harmony import */ var _Admin_admin_scss__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ../Admin/admin.scss */ "./public/src/Admin/admin.scss");
/* harmony import */ var _components_popup_scss__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ../components/popup.scss */ "./public/src/components/popup.scss");
/* harmony import */ var _common__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ../common */ "./public/src/common.js");
/* harmony import */ var _components_dnd_dnd__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! ../components/dnd/dnd */ "./public/src/components/dnd/dnd.js");
/* harmony import */ var _model_question__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! ./model/question */ "./public/src/Test/model/question.js");
// import './test-edit'












new _common__WEBPACK_IMPORTED_MODULE_8__.test_delete_button('.test_delete'); /// class active для admin_main_menu

if (window.location.pathname.match('/adminsc\/test/')) {
  document.querySelector('.module.test').classList.add('activ');
}

(0,_components_dnd_dnd__WEBPACK_IMPORTED_MODULE_9__.check)('/image/create'); //Скрыть все вопросы

(0,_common__WEBPACK_IMPORTED_MODULE_8__.$)('.block').removeClass("flex1"); //Показть первый вопрос

(0,_common__WEBPACK_IMPORTED_MODULE_8__.$)('.block:first-child').addClass("flex1");
(0,_common__WEBPACK_IMPORTED_MODULE_8__.$)('.a-add').on('click', aAdd);
(0,_common__WEBPACK_IMPORTED_MODULE_8__.$)('.q-delete').on('click', e => {
  let res = (0,_model_question__WEBPACK_IMPORTED_MODULE_10__._question)().delete();

  if (res.msg === 'ok') {
    let block = e.target.closest('.block');
    block.remove();
    (0,_common__WEBPACK_IMPORTED_MODULE_8__.$)(`[data-pagination = "${res.q_id}"]`).el[0].remove();
    (0,_common__WEBPACK_IMPORTED_MODULE_8__.$)('[data-pagination]:first-child').addClass('nav-active');
    (0,_common__WEBPACK_IMPORTED_MODULE_8__.$)('.block:first-child').addClass('flex1');
  }
});
(0,_common__WEBPACK_IMPORTED_MODULE_8__.$)('.a-del').on('click', aDelete);
(0,_common__WEBPACK_IMPORTED_MODULE_8__.$)('.without-pagination').on('click', () => {
  (0,_common__WEBPACK_IMPORTED_MODULE_8__.$)('.test-edit__content').el[0].classList.toggle('flex1');
  (0,_common__WEBPACK_IMPORTED_MODULE_8__.$)('.test-edit__content-2').el[0].classList.toggle('flex1');
  addScript();
});

let addScript = () => {
  // let cssLink = $('link[href*="/public/dist/test_edit.css"]').el[0];
  let cssLink = (0,_common__WEBPACK_IMPORTED_MODULE_8__.$)('link[href]').el[0];
  let cloneNode = cssLink.cloneNode(true);
  cloneNode.setAttribute('href', "/public/dist/test_edit_theme_2.css");
  document.head.append(cloneNode);
};

async function aDelete(e) {
  if ((0,_common__WEBPACK_IMPORTED_MODULE_8__.$)(e.target).hasClass('a-del')) {
    if (confirm("Удалить этот ответ?")) {
      let a_id = +e.target.closest('.e-block-a').id;
      let res = await (0,_common__WEBPACK_IMPORTED_MODULE_8__.post)('/answer/delete', {
        a_id
      });
      res = JSON.parse(res);

      if (res.msg === 'ok') {
        let f = e.target.closest('.e-block-a');
        f.remove();
        _common__WEBPACK_IMPORTED_MODULE_8__.popup.show('Ответ удален');
      }
    }
  }
}
async function aAdd(e) {
  if ((0,_common__WEBPACK_IMPORTED_MODULE_8__.$)(e.target).hasClass('a-add')) {
    let q_id = +e.target.closest('.e-block-q').id;
    let res = await (0,_common__WEBPACK_IMPORTED_MODULE_8__.post)('/answer/show', {
      q_id
    });
    let visibleBlock = (0,_common__WEBPACK_IMPORTED_MODULE_8__.$)('.block.flex1').el[0];
    (0,_common__WEBPACK_IMPORTED_MODULE_8__.$)(visibleBlock).find('.answers').insertAdjacentHTML('beforeend', res);
    let newAnswer = (0,_common__WEBPACK_IMPORTED_MODULE_8__.$)(visibleBlock).find('.e-block-a:last-child');
    (0,_common__WEBPACK_IMPORTED_MODULE_8__.$)(newAnswer).css('background-color', 'pink');
    setTimeout(function () {
      (0,_common__WEBPACK_IMPORTED_MODULE_8__.$)(newAnswer).css('background-color', 'white');
    }, 400);
    (0,_common__WEBPACK_IMPORTED_MODULE_8__.$)(newAnswer).on('click', aDelete);
  }
} ///// question sort input validate

(0,_common__WEBPACK_IMPORTED_MODULE_8__.$)('.sort-q').on('change', _common__WEBPACK_IMPORTED_MODULE_8__.validate.sort); ////////// Save событие навешиваем
// на родителя така как могут быть созданы новые блоки

(0,_common__WEBPACK_IMPORTED_MODULE_8__.$)('.blocks').on('click', function (e) {
  if ((0,_common__WEBPACK_IMPORTED_MODULE_8__.$)(e.target).hasClass('question__save')) {
    if ((0,_model_question__WEBPACK_IMPORTED_MODULE_10__._question)().save()) {
      (0,_components_test_pagination_test_pagination__WEBPACK_IMPORTED_MODULE_1__.showHidePaginBtn)(res.paginationButton);
      (0,_components_test_pagination_test_pagination__WEBPACK_IMPORTED_MODULE_1__.appendBlock)();
      _common__WEBPACK_IMPORTED_MODULE_8__.popup.show(res.msg);
    }
  }
}); // export function getAnswers(block, q_id) {
//     let answerBlocks = block.querySelectorAll('.e-block-a')
//     let answers = []
//     answerBlocks.forEach((a) => {
//         answers.push({
//             id: +a.querySelector('.checkbox').dataset['answer'],
//             answer: a.querySelector('textarea').value,
//             correct_answer: +a.querySelector('.checkbox').checked,
//             parent_question: +q_id,
//             pica: '',
//         })
//     }, q_id)
//     return answers
// }

/***/ }),

/***/ "./public/src/common.js":
/*!******************************!*\
  !*** ./public/src/common.js ***!
  \******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
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
/* harmony import */ var _Test_model_test__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_Test_model_test__WEBPACK_IMPORTED_MODULE_0__);

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
};

function clearCache() {
  async function clearCache() {
    let response = await fetch('/adminsc/clearCache');
    let result = await response.text();
  }

  clearCache().catch(alert);
} // function up() {
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
  show: function (txt) {
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
    let delay = 5000;
    let removeDelay = delay + 1000;
    setTimeout(() => {
      popup__item.classList.remove('popup__item');
      popup__item.classList.add('popup-hide');
    }, delay);
    setTimeout(() => {
      popup__item.remove();
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

async function post(url, data) {
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
      let res = _Test_model_test__WEBPACK_IMPORTED_MODULE_0__.test.del();

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

"use strict";
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

/***/ "./public/src/components/dnd/dnd.js":
/*!******************************************!*\
  !*** ./public/src/components/dnd/dnd.js ***!
  \******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "check": () => (/* binding */ check)
/* harmony export */ });
/* harmony import */ var _common__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../common */ "./public/src/common.js");
/* harmony import */ var _dnd_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./dnd.scss */ "./public/src/components/dnd/dnd.scss");


function check(url) {
  let holder = document.getElementsByClassName('holder'),
      tests = {
    filereader: typeof FileReader != 'undefined',
    dnd: 'draggable' in document.createElement('span'),
    formdata: !!window.FormData,
    progress: "upload" in new XMLHttpRequest()
  },
      support = {
    filereader: document.querySelectorAll('.filereader'),
    formdata: document.querySelectorAll('.formdata'),
    progress: document.querySelectorAll('.progress')
  },
      acceptedTypes = {
    'image/png': true,
    'image/jpeg': true,
    'image/gif': true
  },
      progress = document.getElementById('uploadprogress'),
      fileupload = document.getElementById('upload'),
      message = "filereader formdata progress".split(' '); // преобразует строку в массив, разбив по сепаратору

  for (var key in message) {
    //(function (api)
    if (tests[message[key]] === false) {
      support[message[key]].className = 'fail'; // присвоим класс
    } else {
      let collItem = support[message[key]];

      for (var key1 = 0; key1 < collItem.length; ++key1) {
        var item = collItem[key1]; // Вызов myNodeList.item(i) необязателен в JavaScript

        item.className = 'hidden';
      }
    }
  }

  if (tests.dnd) {
    for (let i = 0; i < holder.length; i++) {
      holder[i].ondragover = function () {
        this.className = 'hover';
        this.style.width = '234px';
        this.style.height = '162px';
        return false;
      };

      holder[i].ondragleave = function () {
        this.className = 'holder';
        return false;
      };

      holder[i].ondragend = function () {
        this.className = '';
        return false;
      };

      holder[i].ondrop = function (e) {
        this.className = 'holder';
        e.preventDefault();
        readfiles(e.dataTransfer.files, this);
      };
    }
  } else {
    fileupload.className = 'hidden'; // прячем кнопку загрузки

    fileupload.querySelector('input').onchange = function () {
      // загружаем файлы
      readfiles(this.files);
    };
  }

  function previewfile(file, elem) {
    if (tests.filereader === true && acceptedTypes[file.type] === true) {
      var imageContainer = elem,
          //document.querySelector('#'+fid+' [data-prefix = "'+pref+'"]');
      reader = new FileReader();

      reader.onload = function (event) {
        if (imageContainer.getElementsByTagName('img').length) {
          var elem = imageContainer.getElementsByTagName('img')[0];
          elem.remove();
        }

        var image = new Image();

        if (imageContainer.getAttribute('data-prefix') === 'q') {
          image.id = 'imq' + imageContainer.getAttribute('id');
        } else if (imageContainer.getAttribute('data-prefix') === 'a') {
          image.id = 'ima' + imageContainer.getAttribute('id');
        }

        image.src = event.target.result; // image.width = 150; // a fake resize

        imageContainer.appendChild(image);
      };

      reader.readAsDataURL(file);
    } else {
      holder.innerHTML += '<p>Загружен ' + file.name + ' ' + (file.size ? (file.size / 1024 | 0) + 'K' : '');
      console.log(file);
    }
  }

  async function readfiles(files, elem) {
    let formData = new FormData();

    for (var i = 0; i < files.length; i++) {
      formData.append('file', files[i], files[i]['name']);
      formData.append('type', elem.dataset['prefix']);
      formData.append('typeId', elem.id);
      previewfile(files[i], elem);
    }

    let res = await fetch(url, {
      method: 'POST',
      body: formData
    }); // let res = await post(url, formData)
    // if (res) {
    //     alert(res)
    // }
  }
}

/***/ }),

/***/ "./public/src/components/header/autocomplete.js":
/*!******************************************************!*\
  !*** ./public/src/components/header/autocomplete.js ***!
  \******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
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

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _top_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./top.scss */ "./public/src/components/header/top.scss");
/* harmony import */ var _header_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./header.scss */ "./public/src/components/header/header.scss");



/***/ }),

/***/ "./public/src/components/test-pagination/test-pagination.js":
/*!******************************************************************!*\
  !*** ./public/src/components/test-pagination/test-pagination.js ***!
  \******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "showHidePaginBtn": () => (/* binding */ showHidePaginBtn),
/* harmony export */   "appendBlock": () => (/* binding */ appendBlock)
/* harmony export */ });
/* harmony import */ var _test_pagination_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./test-pagination.scss */ "./public/src/components/test-pagination/test-pagination.scss");
/* harmony import */ var _common__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../common */ "./public/src/common.js");
/* harmony import */ var _Test_test_edit__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../Test/test-edit */ "./public/src/Test/test-edit.js");
/* harmony import */ var _Test_model_question__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../Test/model/question */ "./public/src/Test/model/question.js");
 // import {questionSave} from '../../Test/model/question'



 //Скрыть все кнопки

(0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('[data-pagination]').removeClass('nav-active'); // Показать первую кнопку

(0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('[data-pagination]:first-child').addClass('nav-active'); //// add question

(0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('.pagination').on('click', function (e) {
  if (e.target.classList.contains('add-question')) {
    show();
    return;
  } //// paginate


  if (e.target.getAttribute('data-pagination')) {
    paginate(e.target);
    return;
  }
});

function paginate(self) {
  /// get clicked button Return if clicked is active
  if (self.classList.contains('nav-active')) return;
  let active_btn = (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('.pagination .nav-active').el[0]; //// change active button

  active_btn.classList.remove('nav-active');
  self.classList.add('nav-active'); //// hide the card

  let id_to_hide = active_btn.dataset['pagination'];
  (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)(`#question-${id_to_hide}`).removeClass('flex1'); //// show the card

  let id_to_show = self.dataset['pagination'];
  (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)(`#question-${id_to_show}`).addClass('flex1');
} //// добавление вопроса


async function show(e) {
  let testid = +(0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('.test-name').value();
  let questCount = (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)("[data-pagination]").count();
  let res = await (0,_common__WEBPACK_IMPORTED_MODULE_1__.post)('/question/show', {
    testid,
    questCount
  });
  res = JSON.parse(res);
  let Block = res.block;
  let blocks = (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('.blocks').el[0];
  blocks.insertAdjacentHTML('afterBegin', Block);
  let newBlock = (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('.blocks .block:first-child').el[0];
  document.querySelector('.flex1').classList.remove('flex1');
  (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)(newBlock).addClass('flex1');
  let save_button = (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)(newBlock).find('.question__save');
  (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)(save_button).on('click', (0,_Test_model_question__WEBPACK_IMPORTED_MODULE_3__._question)().save); // $('.overlay').on('click', clickOverlay)
}

function showHidePaginBtn(pagItem) {
  let activePaginBtn = (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('.pagination .nav-active').el[0];

  if (activePaginBtn) {
    activePaginBtn.classList.remove('nav-active');
  }

  (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('.add-question').el[0].insertAdjacentHTML('beforeBegin', pagItem);
}

function appendBlock() {
  let block = (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('.overlay').find('.block');
  (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('.blocks').append(block);
  (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)(block).addClass('flex1');
  (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('.a-add').on('click', _Test_test_edit__WEBPACK_IMPORTED_MODULE_2__.aAdd);
  (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('.q-delete').on('click', (0,_Test_model_question__WEBPACK_IMPORTED_MODULE_3__._question)().delete());
  (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('.a-del').on('click', _Test_test_edit__WEBPACK_IMPORTED_MODULE_2__.aDelete);
}

function hideVisibleBlock() {
  (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('.block.flex1').removeClass('flex1');
}



/***/ }),

/***/ "./public/src/Admin/admin.scss":
/*!*************************************!*\
  !*** ./public/src/Admin/admin.scss ***!
  \*************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./public/src/Test/do.scss":
/*!*********************************!*\
  !*** ./public/src/Test/do.scss ***!
  \*********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./public/src/Test/show.scss":
/*!***********************************!*\
  !*** ./public/src/Test/show.scss ***!
  \***********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./public/src/Test/test-edit.scss":
/*!****************************************!*\
  !*** ./public/src/Test/test-edit.scss ***!
  \****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./public/src/components/cookie/cookie.scss":
/*!**************************************************!*\
  !*** ./public/src/components/cookie/cookie.scss ***!
  \**************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./public/src/components/dnd/dnd.scss":
/*!********************************************!*\
  !*** ./public/src/components/dnd/dnd.scss ***!
  \********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./public/src/components/footer/footer.scss":
/*!**************************************************!*\
  !*** ./public/src/components/footer/footer.scss ***!
  \**************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./public/src/components/header/autocomplete.scss":
/*!********************************************************!*\
  !*** ./public/src/components/header/autocomplete.scss ***!
  \********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./public/src/components/header/header.scss":
/*!**************************************************!*\
  !*** ./public/src/components/header/header.scss ***!
  \**************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./public/src/components/header/top.scss":
/*!***********************************************!*\
  !*** ./public/src/components/header/top.scss ***!
  \***********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./public/src/components/popup.scss":
/*!******************************************!*\
  !*** ./public/src/components/popup.scss ***!
  \******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./public/src/components/test-pagination/test-pagination.scss":
/*!********************************************************************!*\
  !*** ./public/src/components/test-pagination/test-pagination.scss ***!
  \********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./public/src/normalize.scss":
/*!***********************************!*\
  !*** ./public/src/normalize.scss ***!
  \***********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
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
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
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
// This entry need to be wrapped in an IIFE because it need to be in strict mode.
(() => {
"use strict";
/*!*********************************!*\
  !*** ./public/src/Test/test.js ***!
  \*********************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _do__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./do */ "./public/src/Test/do.js");
/* harmony import */ var _normalize_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../normalize.scss */ "./public/src/normalize.scss");
/* harmony import */ var _components_test_pagination_test_pagination__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../components/test-pagination/test-pagination */ "./public/src/components/test-pagination/test-pagination.js");
/* harmony import */ var _components_header_header__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../components/header/header */ "./public/src/components/header/header.js");
/* harmony import */ var _components_footer_footer_scss__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../components/footer/footer.scss */ "./public/src/components/footer/footer.scss");





})();

/******/ })()
;
//# sourceMappingURL=test.js.map