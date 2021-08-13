/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

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
  create: async e => {
    if ((0,_common__WEBPACK_IMPORTED_MODULE_0__.$)(e.target).hasClass('a-add')) {
      let q_id = +e.target.closest('.e-block-q').id;
      let res = await (0,_common__WEBPACK_IMPORTED_MODULE_0__.post)('/answer/show', {
        q_id
      });
      let visibleBlock = (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.block.flex1').el[0];
      (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)(visibleBlock).find('.answers').insertAdjacentHTML('beforeend', res);
      let newAnswer = (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)(visibleBlock).find('.e-block-a:last-child');
      (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)(newAnswer).css('background-color', 'pink');
      setTimeout(function () {
        (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)(newAnswer).css('background-color', 'white');
      }, 400);
      (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)(newAnswer).on('click', undefined.delete);
    }
  },
  update: () => {},
  delete: async function (e) {
    if ((0,_common__WEBPACK_IMPORTED_MODULE_0__.$)(e.target).hasClass('a-del')) {
      if (confirm("Удалить этот ответ?")) {
        let a_id = +e.target.closest('.e-block-a').id;
        let res = await (0,_common__WEBPACK_IMPORTED_MODULE_0__.post)('/answer/delete', {
          a_id
        });
        res = JSON.parse(res);

        if (res.msg === 'ok') {
          let f = e.target.closest('.e-block-a');
          f.remove();
          _common__WEBPACK_IMPORTED_MODULE_0__.popup.show('Ответ удален');
        }
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


function _question(id) {
  let q = id ? (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)(`.e-block-q#{id}`).el[0] : (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.block.flex1 .e-block-q').el[0];
  return new question(q);
}

function question(q) {
  this.q = q;

  this.add = function () {};

  this.showFirst = () => {
    (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.block:first-child').addClass('flex1');
  };

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
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "_test": () => (/* binding */ _test)
/* harmony export */ });
/* harmony import */ var _common__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../common */ "./public/src/common.js");

let _test = {
  id: id => {
    return id ?? (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.test-name').value();
  },
  name: () => {
    return (0,_common__WEBPACK_IMPORTED_MODULE_0__.$)('.test-name').el[0].innerText;
  },
  create: () => {},
  delete: async function () {
    let res = await (0,_common__WEBPACK_IMPORTED_MODULE_0__.post)('/test/delete', {
      id: this.id
    });
    return await JSON.parse(res);
  }
};

/***/ }),

/***/ "./public/src/Test/show.js":
/*!*********************************!*\
  !*** ./public/src/Test/show.js ***!
  \*********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

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

/***/ "./public/src/Test/test_edit_theme_2.js":
/*!**********************************************!*\
  !*** ./public/src/Test/test_edit_theme_2.js ***!
  \**********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _test_edit_theme_2_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./test_edit_theme_2.scss */ "./public/src/Test/test_edit_theme_2.scss");
/* harmony import */ var _model_answer__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./model/answer */ "./public/src/Test/model/answer.js");
/* harmony import */ var _common__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../common */ "./public/src/common.js");



(0,_common__WEBPACK_IMPORTED_MODULE_2__.$)('.answer__create-button').on('click', function (e) {
  let button = e.target;
  let answers = button.parentNode.querySelector('.answer');
  let lastAnswer = answers.querySelector('.answer')[answers.length];
  let clone = lastAnswer.cloneNode(true);
  let sort = (0,_common__WEBPACK_IMPORTED_MODULE_2__.$)(lastAnswer).find('.answer__sort').innerText;
  let newSort = (0,_common__WEBPACK_IMPORTED_MODULE_2__.$)(clone).find('.answer__sort');
  newSort.innerText = sort + 1;
  clone.style.display = 'flex';
  button.before(clone);
  clone.style.opacity = 1;

  if (_model_answer__WEBPACK_IMPORTED_MODULE_1__._answer.create) {
    let create__answerButton = 0;
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

/***/ "./public/src/components/dnd/dnd.js":
/*!******************************************!*\
  !*** ./public/src/components/dnd/dnd.js ***!
  \******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

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

/***/ "./public/src/components/header/header.js":
/*!************************************************!*\
  !*** ./public/src/components/header/header.js ***!
  \************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _top_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./top.scss */ "./public/src/components/header/top.scss");
/* harmony import */ var _header_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./header.scss */ "./public/src/components/header/header.scss");



/***/ }),

/***/ "./public/src/components/test-pagination/test-pagination.js":
/*!******************************************************************!*\
  !*** ./public/src/components/test-pagination/test-pagination.js ***!
  \******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "showHidePaginBtn": () => (/* binding */ showHidePaginBtn),
/* harmony export */   "appendBlock": () => (/* binding */ appendBlock)
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
} // function hideVisibleBlock() {
//     $('.block.flex1').removeClass('flex1')
// }




/***/ }),

/***/ "./public/src/Admin/admin.scss":
/*!*************************************!*\
  !*** ./public/src/Admin/admin.scss ***!
  \*************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./public/src/Test/show.scss":
/*!***********************************!*\
  !*** ./public/src/Test/show.scss ***!
  \***********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./public/src/Test/test-edit.scss":
/*!****************************************!*\
  !*** ./public/src/Test/test-edit.scss ***!
  \****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./public/src/Test/test_edit_theme_2.scss":
/*!************************************************!*\
  !*** ./public/src/Test/test_edit_theme_2.scss ***!
  \************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./public/src/components/dnd/dnd.scss":
/*!********************************************!*\
  !*** ./public/src/components/dnd/dnd.scss ***!
  \********************************************/
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
/*!**************************************!*\
  !*** ./public/src/Test/test-edit.js ***!
  \**************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _normalize_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../normalize.scss */ "./public/src/normalize.scss");
/* harmony import */ var _components_test_pagination_test_pagination__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../components/test-pagination/test-pagination */ "./public/src/components/test-pagination/test-pagination.js");
/* harmony import */ var _components_header_header__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../components/header/header */ "./public/src/components/header/header.js");
/* harmony import */ var _components_footer_footer_scss__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../components/footer/footer.scss */ "./public/src/components/footer/footer.scss");
/* harmony import */ var _test_edit_scss__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./test-edit.scss */ "./public/src/Test/test-edit.scss");
/* harmony import */ var _show__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./show */ "./public/src/Test/show.js");
/* harmony import */ var _Test_test_edit_theme_2__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ../Test/test_edit_theme_2 */ "./public/src/Test/test_edit_theme_2.js");
/* harmony import */ var _Admin_admin_scss__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ../Admin/admin.scss */ "./public/src/Admin/admin.scss");
/* harmony import */ var _components_popup_scss__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ../components/popup.scss */ "./public/src/components/popup.scss");
/* harmony import */ var _common__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! ../common */ "./public/src/common.js");
/* harmony import */ var _components_dnd_dnd__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! ../components/dnd/dnd */ "./public/src/components/dnd/dnd.js");
/* harmony import */ var _model_question__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! ./model/question */ "./public/src/Test/model/question.js");
/* harmony import */ var _model_test__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! ./model/test */ "./public/src/Test/model/test.js");
/* harmony import */ var _model_answer__WEBPACK_IMPORTED_MODULE_13__ = __webpack_require__(/*! ./model/answer */ "./public/src/Test/model/answer.js");















let newAnser = (0,_common__WEBPACK_IMPORTED_MODULE_9__.$)('.answer__create');
(0,_common__WEBPACK_IMPORTED_MODULE_9__.$)('.question__text').on('click', function (e) {
  let text = e.target;
  let parent = text.parentNode.parentNode;
  let answers = (0,_common__WEBPACK_IMPORTED_MODULE_9__.$)(parent).find('.question__answers');
  answers.classList.toggle('height');
  answers.classList.toggle('scale'); // answers.style.transform = 'scaleY(1)'

  text.classList.toggle('rotate'); // answers.style.height = 'auto'
});

(0,_model_question__WEBPACK_IMPORTED_MODULE_11__._question)().showFirst();

(0,_common__WEBPACK_IMPORTED_MODULE_9__.$)('.test_delete').on('click', _model_test__WEBPACK_IMPORTED_MODULE_12__._test.delete); /// class active для admin_main_menu

if (window.location.pathname.match('/adminsc\/test/')) {
  document.querySelector('.module.test').classList.add('activ');
}

(0,_components_dnd_dnd__WEBPACK_IMPORTED_MODULE_10__.check)('/image/create');
(0,_common__WEBPACK_IMPORTED_MODULE_9__.$)('.a-add').on('click', _model_answer__WEBPACK_IMPORTED_MODULE_13__._answer.create);
(0,_common__WEBPACK_IMPORTED_MODULE_9__.$)('.a-del').on('click', _model_answer__WEBPACK_IMPORTED_MODULE_13__._answer.delete);
(0,_common__WEBPACK_IMPORTED_MODULE_9__.$)('.q-delete').on('click', e => {
  let res = (0,_model_question__WEBPACK_IMPORTED_MODULE_11__._question)().delete();

  if (res.msg === 'ok') {
    let block = e.target.closest('.block');
    block.remove();
    (0,_common__WEBPACK_IMPORTED_MODULE_9__.$)(`[data-pagination = "${res.q_id}"]`).el[0].remove();
    (0,_common__WEBPACK_IMPORTED_MODULE_9__.$)('[data-pagination]:first-child').addClass('nav-active');
    (0,_common__WEBPACK_IMPORTED_MODULE_9__.$)('.block:first-child').addClass('flex1');
  }
});
toggleTheme();
(0,_common__WEBPACK_IMPORTED_MODULE_9__.$)('.without-pagination').on('click', () => {
  toggleTheme();
});

function toggleTheme() {
  (0,_common__WEBPACK_IMPORTED_MODULE_9__.$)('.test-edit__content').el[0].classList.toggle('flex1');
  (0,_common__WEBPACK_IMPORTED_MODULE_9__.$)('.test-edit__content-2').el[0].classList.toggle('flex1');
} ///// question sort input validate


(0,_common__WEBPACK_IMPORTED_MODULE_9__.$)('.sort-q').on('change', _common__WEBPACK_IMPORTED_MODULE_9__.validate.sort); ////////// Save событие навешиваем
// на родителя така как могут быть созданы новые блоки

(0,_common__WEBPACK_IMPORTED_MODULE_9__.$)('.blocks').on('click', function (e) {
  if ((0,_common__WEBPACK_IMPORTED_MODULE_9__.$)(e.target).hasClass('question__save')) {
    if ((0,_model_question__WEBPACK_IMPORTED_MODULE_11__._question)().save()) {
      (0,_components_test_pagination_test_pagination__WEBPACK_IMPORTED_MODULE_1__.showHidePaginBtn)(res.paginationButton);
      (0,_components_test_pagination_test_pagination__WEBPACK_IMPORTED_MODULE_1__.appendBlock)();
      _common__WEBPACK_IMPORTED_MODULE_9__.popup.show(res.msg);
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
})();

/******/ })()
;
//# sourceMappingURL=test_edit.js.map