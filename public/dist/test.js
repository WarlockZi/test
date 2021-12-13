/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./public/src/Test/do.js":
/*!*******************************!*\
  !*** ./public/src/Test/do.js ***!
  \*******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _common__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../common */ "./public/src/common.js");
/* harmony import */ var _do_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./do.scss */ "./public/src/Test/do.scss");
/* harmony import */ var _components_header_autocomplete__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../components/header/autocomplete */ "./public/src/components/header/autocomplete.js");
/* harmony import */ var _components_cookie_cookie__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../components/cookie/cookie */ "./public/src/components/cookie/cookie.js");
/* harmony import */ var _model_test__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./model/test */ "./public/src/Test/model/test.js");
/* harmony import */ var _components_accordion_accordion__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../components/accordion/accordion */ "./public/src/components/accordion/accordion.js");
/* harmony import */ var _components_test_pagination_test_pagination__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ../components/test-pagination/test-pagination */ "./public/src/components/test-pagination/test-pagination.js");






 // acc.init({
//     api:'test-menu',
// })
//Скрыть все вопросы

(0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.question').removeClass("flex1"); //Показть первый вопрос

(0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.question:first-child').addClass("flex1"); // Нажать первуюкнопку navigation

(0,_components_test_pagination_test_pagination__WEBPACK_IMPORTED_MODULE_6__.navInit)();
(0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('[type="checkbox"]').on('click', function (e) {
  let a = e.target.labels[0];
  a.classList.toggle('pushed');
});
(0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('#prev').on('click', _model_test__WEBPACK_IMPORTED_MODULE_4__._test.prevQ);
(0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('#next').on('click', _model_test__WEBPACK_IMPORTED_MODULE_4__._test.nextQ); /////////////////////////////////////////////////////////////////////////////
///////////  RESULTS  TEST  Закончить тест/////////////////////////////
/////////////////////////////////////////////////////////////////////////////
// если это результат теста, деактивирукм кнопку Закончить тест

if (window.location.pathname.match(/result/)) {
  let button = (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.test-do__finish-btn').el[0];
  button.classList.add('inactive');
}

(0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.test-do__finish-btn').on('click', async function (e) {
  let button = e.target;
  if (button.classList.contains('inactive')) return false;
  if (button.id !== 'btnn') return false;

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
    (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)("#btnn").el[0].href = location.href;
    (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)("#btnn").el[0].text = "ПРОЙТИ ТЕСТ ЗАНОВО";
  }
});

function objToServer(errorCnt) {
  let obj = {
    token: document.querySelector('meta[name="token"]').getAttribute('content'),
    questionCnt: (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.question').el.length,
    errorCnt: errorCnt,
    pageCache: `<!DOCTYPE ${document.doctype.name}>` + document.documentElement.outerHTML,
    testId: (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('[data-test-id]').el[0].dataset.testId,
    test_name: (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.test-name').el[0].innerText,
    userName: (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.user-menu__FIO').el[0].innerText
  };
  let formData = new FormData();
  formData.append('token', obj.token);
  formData.append('questionCnt', obj.questionCnt);
  formData.append('errorCnt', obj.errorCnt);
  formData.append('pageCache', obj.pageCache);
  formData.append('testId', obj.testId);
  formData.append('test_name', obj.test_name);
  formData.append('userName', obj.userName);
  return formData;
  return obj;
}

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

/***/ }),

/***/ "./public/src/Test/model/answer.js":
/*!*****************************************!*\
  !*** ./public/src/Test/model/answer.js ***!
  \*****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "_answer": () => (/* binding */ _answer)
/* harmony export */ });
/* harmony import */ var _common__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../common */ "./public/src/common.js");

let _answer = {
  el: add_button => {
    let answers = add_button.parentNode.querySelectorAll('.answer');
    let prev_sort = 0;

    if (answers.length) {
      prev_sort = +(0,_common__WEBPACK_IMPORTED_MODULE_0__.$)(answers[answers.length - 1]).find('.answer__sort').innerText;
    }

    let el = (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.answer__create').find('.answer').cloneNode(true);
    el.classList.add('answer');
    el.classList.remove('answer__create');
    return {
      el: el,
      id: 'new',
      q_id: +add_button.closest('.question-edit').id,
      previous_sort: prev_sort,
      sort: (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)(el).find('.answer__sort'),
      checked: (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)(el).find('input'),
      text: (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)(el).find('.answer__text'),
      delete: (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)((0,_common__WEBPACK_IMPORTED_MODULE_0__.$)(el).find('.answer__delete')).on('click', function () {
        _answer.del(this);
      })
    };
  },

  getModelForServer(el) {
    return {
      answer: '',
      parent_question: el.q_id,
      correct_answer: 0,
      pica: ''
    };
  },

  async create(e) {
    let button = e.target;
    let a_id = await createOnServer(button);
    show(a_id);

    async function createOnServer(button) {
      let newEl = _answer.getModelForServer(_answer.el(button));

      let res = await (0,_common__WEBPACK_IMPORTED_MODULE_0__.post)('/answer/create', newEl);
      res = JSON.parse(res);
      return res.id;
    }

    function show(a_id) {
      let el = _answer.el(button);

      el.checked.checked = false;
      el.el.dataset['answerId'] = a_id;
      el.text.innerText = '';
      el.sort.innerText = el.previous_sort + 1;
      el.el.style.display = 'flex';
      button.before(el.el);
      el.el.style.opacity = 1;
    }
  },

  async del(e) {
    let del_button = e.target;

    if (confirm("Удалить этот ответ?")) {
      await deleteFromServer(del_button);
      deleteFromView(del_button);
    }

    function deleteFromView(del_button) {
      del_button.closest('.answer').remove();
    }

    async function deleteFromServer(del_button) {
      let a_id = +del_button.closest('.answer').dataset['answerId'];
      let res = await (0,_common__WEBPACK_IMPORTED_MODULE_0__.post)('/answer/delete', {
        a_id
      });
      res = JSON.parse(res);

      if (res.msg === 'ok') {
        _common__WEBPACK_IMPORTED_MODULE_0__.popup.show('Ответ удален');
      }
    }
  }

};

/***/ }),

/***/ "./public/src/Test/model/question.js":
/*!*******************************************!*\
  !*** ./public/src/Test/model/question.js ***!
  \*******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "_question": () => (/* binding */ _question)
/* harmony export */ });
/* harmony import */ var _common__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../common */ "./public/src/common.js");
/* harmony import */ var _answer__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./answer */ "./public/src/Test/model/answer.js");


let _question = {
  sort: async function (upToQestionNumber) {
    let questions = [..._question.questions()];
    let questionsEls = questions.filter(function (el, i) {
      if (i + 1 < upToQestionNumber) return el;
    });
    let toChange = questionsEls.map(el => {
      return el.id;
    });
    let res = await (0,_common__WEBPACK_IMPORTED_MODULE_0__.post)('/question/sort', {
      toChange
    });
    res = JSON.parse(res);

    if (res.msg) {
      _common__WEBPACK_IMPORTED_MODULE_0__.popup.show(res.msg);
    }

    questionsEls.map((el, i) => {
      (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)(el).find('.question__sort').innerText = i + 1;
    });
  },
  showTip: (action, event) => {
    let el = event.target;
    let tip = document.createElement("div");

    if (action === 'save') {
      (0,_common__WEBPACK_IMPORTED_MODULE_0__.addTooltip)(el, 'сохранить');
    }
  },
  showFirst: () => {
    let question = _question.cloneEmptyModel();

    if (!question) return;

    let model = _question.viewModel(question);

    model.sort.innerText = '1';
    (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)(model.save).on('click', _question.save);
    (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)(model.del).on('click', _question.delete);
    (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)(question).addClass('question-edit');
    (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)(question).removeClass('question__create');
    let questions = (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.questions').el[0];
    questions.prepend(question);
  },
  cloneEmptyModel: () => {
    let question = (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.questions .question__create .question-edit').el[0];
    if (question) return question.cloneNode(true);
  },
  showAnswers: e => {
    let text = e.target;
    let parent = text.parentNode.parentNode;
    let answers = (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)(parent).find('.question__answers');
    answers.classList.toggle('height');
    answers.classList.toggle('scale');
    text.classList.toggle('rotate');
  },
  viewModel: el => {
    return {
      id: +el.id,
      el: el,
      sort: el.querySelector('.question__sort'),
      save: el.querySelector('.question__save'),
      text: el.querySelector('.question__text'),
      del: el.querySelector('.question__delete'),
      createAnswerButton: el.querySelector('.answer__create-button'),
      addButton: (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)((0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.questions').el[0]).find('.question__create-button')
    };
  },
  serverModel: () => {
    return {
      question: {
        id: null,
        qustion: '',
        parent: +window.location.href.split('/').pop(),
        sort: _question.questionsCount()
      }
    };
  },
  questions: () => {
    return (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.questions>.question-edit').el;
  },
  questionsCount: () => {
    return (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.questions>.question-edit').el.length;
  },
  create: async e => {
    let q_id = await _question.createOnServer(e);

    if (q_id) {
      _question.createOnView(q_id);
    }
  },
  createOnServer: async () => {
    let question = _question.serverModel();

    let res = await (0,_common__WEBPACK_IMPORTED_MODULE_0__.post)('/question/updateOrCreate', {
      question: question.question,
      answers: {}
    });
    res = await JSON.parse(res);
    return res.id;
  },
  createOnView: q_id => {
    let clone = _question.cloneEmptyModel();

    let model = _question.viewModel(clone);

    (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)(model.save).on('click', _question.save);
    (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)(model.del).on('click', _question.delete);
    (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)(model.text).on('click', _question.showAnswers);
    (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)(model.createAnswerButton).on('click', _answer__WEBPACK_IMPORTED_MODULE_1__._answer.create);
    model.sort.innerText = _question.questions().length + 1;
    model.text.innerText = '';
    model.el.id = q_id;
    model.addButton.before(clone);
  },
  save: async e => {
    let question = e.target.closest('.question-edit');
    let res = await (0,_common__WEBPACK_IMPORTED_MODULE_0__.post)('/question/UpdateOrCreate', {
      question: _question.getModelForServer(question),
      answers: _question.getAnswers(question)
    });
    res = await JSON.parse(res);
    _common__WEBPACK_IMPORTED_MODULE_0__.popup.show(res.msg);
  },
  delete: async e => {
    if (confirm("Удалить вопрос со всеми его ответами?")) {
      let viewModel = _question.viewModel(e.target.closest('.question-edit'));

      let id = viewModel.id;
      let deleted = await _question.deleteFromServer(id);

      if (deleted) {
        _question.deleteFromView(viewModel);

        _common__WEBPACK_IMPORTED_MODULE_0__.popup.show(deleted.msg);
      }
    }
  },
  deleteFromView: async viewModel => {
    viewModel.el.remove();
  },
  deleteFromServer: async q_id => {
    let res = await (0,_common__WEBPACK_IMPORTED_MODULE_0__.post)('/question/delete', {
      q_id
    });
    return JSON.parse(res);
  },
  getModelForServer: question => {
    return {
      id: +question.id,
      parent: +(0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.test-name').el[0].getAttribute('value'),
      picq: '',
      qustion: (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)(question).find('.question__text').innerText,
      sort: +(0,_common__WEBPACK_IMPORTED_MODULE_0__.$)(question).find('.question__sort').innerText
    };
  },
  getAnswers: question => {
    let answerBlocks = question.querySelectorAll('.answer');
    return [...answerBlocks].map(a => {
      return {
        id: +a.dataset['answerId'],
        answer: a.querySelector('.answer__text').innerText,
        correct_answer: +a.querySelector('[type="checkbox"]').checked,
        parent_question: +question.id,
        pica: ''
      };
    }, question);
  }
};

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

const _test = {
  markCurrentInMenu: () => {
    let currentTestId = (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.test-name').el[0];

    if (currentTestId) {
      currentTestId = +currentTestId.getAttribute('value');
      let menuItemCollection = (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.accordion a').el;
      Array.from(menuItemCollection).filter(a => {
        if (+a.dataset.id === currentTestId) {
          a.classList.add('current');
        }
      });
    }
  },
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
      test_name: (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('#test_name').el[0].value,
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
/* harmony import */ var _common_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./common.scss */ "./public/src/common.scss");

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

/***/ "./public/src/components/accordion/accordion.js":
/*!******************************************************!*\
  !*** ./public/src/components/accordion/accordion.js ***!
  \******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _accordion_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./accordion.scss */ "./public/src/components/accordion/accordion.scss");
/* harmony import */ var _common__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../common */ "./public/src/common.js");
/* harmony import */ var _customContextMenu_customMenu__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./customContextMenu/customMenu */ "./public/src/components/accordion/customContextMenu/customMenu.js");



(0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('.accordion label').on('click', handle);
(0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('.test-edit__accordion .accordion a').on('mouseenter', _customContextMenu_customMenu__WEBPACK_IMPORTED_MODULE_2__.default);
(0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('.test-edit__accordion .accordion label').on('mouseenter', _customContextMenu_customMenu__WEBPACK_IMPORTED_MODULE_2__.default);

function handle(e) {
  let checkbox = e.target.previousElementSibling;
  let parent = checkbox.closest('ul');
  let ul = checkbox.nextElementSibling.nextElementSibling;

  if (checkbox.checked) {
    slideUp(ul, 0);
  } else {
    parent.style.height = "auto";
    let height = slideDown(ul, 0);
    increaseParent(parent, height);
    closeSiblings(parent);
  }
}

function increaseParent(parent, height) {
  if (!parent.classList.contains('accordion')) {
    let final = height + parseInt(parent.style.maxHeight);
    parent.style.maxHeight = final + "px";
  }
}

function slideDown(ul, interval, callback) {
  ul.style.maxHeight = ul.scrollHeight + "px";

  if (callback) {
    callback();
  }

  return ul.scrollHeight;
}

function closeSiblings(parent) {
  Array.from(parent.children).map(el => {
    let elArr = Array.from(el.children);
    elArr.map(ch => {
      if (ch.type && ch.type === 'checkbox' && ch.checked) {
        let ul = ch.nextElementSibling.nextElementSibling;
        slideUp(ul, 0, function () {
          ch.checked = false;
        });
      }
    });
  });
}

function slideUp(ul, interval, callback) {
  ul.style.maxHeight = 0 + "px";

  if (callback) {
    callback();
  }
}

/***/ }),

/***/ "./public/src/components/accordion/customContextMenu/customMenu.js":
/*!*************************************************************************!*\
  !*** ./public/src/components/accordion/customContextMenu/customMenu.js ***!
  \*************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ showCustomMenu)
/* harmony export */ });
/* harmony import */ var _common__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../common */ "./public/src/common.js");

function showCustomMenu(e) {
  $remove();
  let el = e.target;
  el.append(render(e));
  el.addEventListener('mouseleave', $remove.bind(null, this));
}

function $remove() {
  let updates = document.querySelectorAll('.accordion .update');
  updates.forEach(el => el.remove());
}

function render(e) {
  let div = document.createElement('a');
  let id = e.target.dataset.id ?? e.target.getAttribute('for');
  div.classList.add('update');
  div.href = `/adminsc/test/update/${id}`; // div.innerText = 'Изменить'

  return div;
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
/* harmony import */ var _header_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./header.scss */ "./public/src/components/header/header.scss");
// import './top.scss'


/***/ }),

/***/ "./public/src/components/test-pagination/test-pagination.js":
/*!******************************************************************!*\
  !*** ./public/src/components/test-pagination/test-pagination.js ***!
  \******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "showHidePaginBtn": () => (/* binding */ showHidePaginBtn),
/* harmony export */   "appendBlock": () => (/* binding */ appendBlock),
/* harmony export */   "navInit": () => (/* binding */ navInit)
/* harmony export */ });
/* harmony import */ var _test_pagination_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./test-pagination.scss */ "./public/src/components/test-pagination/test-pagination.scss");
/* harmony import */ var _common__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../common */ "./public/src/common.js");
/* harmony import */ var _Test_model_question__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../Test/model/question */ "./public/src/Test/model/question.js");
/* harmony import */ var _Test_model_answer__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../Test/model/answer */ "./public/src/Test/model/answer.js");



 // Показать первую кнопку

(0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('[data-pagination]:first-child').addClass('nav-active');
(0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('.test-edit__content').addClass('flex1'); //// add question

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
  (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)(save_button).on('click', (0,_Test_model_question__WEBPACK_IMPORTED_MODULE_2__._question)().save);
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
  (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('.a-add').on('click', _Test_model_answer__WEBPACK_IMPORTED_MODULE_3__._answer.create);
  (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('.q-delete').on('click', (0,_Test_model_question__WEBPACK_IMPORTED_MODULE_2__._question)().delete());
  (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('.a-del').on('click', _Test_model_answer__WEBPACK_IMPORTED_MODULE_3__._answer.delete());
}

function navInit() {
  let nav_buttons = (0,_common__WEBPACK_IMPORTED_MODULE_1__.$)('[data-pagination]').el;
  if (!nav_buttons[0]) return false;
  Array.from(nav_buttons).map(el => {
    el.classList.remove('nav-active');
  });
  nav_buttons[0].classList.add('nav-active');
} // function hideVisibleBlock() {
//     $('.block.flex1').removeClass('flex1')
// }




/***/ }),

/***/ "./public/src/Test/do.scss":
/*!*********************************!*\
  !*** ./public/src/Test/do.scss ***!
  \*********************************/
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

/***/ "./public/src/components/accordion/accordion.scss":
/*!********************************************************!*\
  !*** ./public/src/components/accordion/accordion.scss ***!
  \********************************************************/
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

/***/ "./public/src/components/test-pagination/test-pagination.scss":
/*!********************************************************************!*\
  !*** ./public/src/components/test-pagination/test-pagination.scss ***!
  \********************************************************************/
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