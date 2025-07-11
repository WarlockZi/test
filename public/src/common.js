"use strict";

const scrollToTop = () => {
  const c = document.documentElement.scrollTop || document.body.scrollTop;
  if (c > 0) {
    window.requestAnimationFrame(scrollToTop);
    window.scrollTo(0, c - c / 8);
  }
};
export const formatter = new Intl.NumberFormat("ru", {
  style: "currency",
  currency: "RUB",
  minimumFractionDigits: 2,
});

export function objAndFiles2FormData(obj, files, formData = new FormData()) {
  debugger;
  self.formData = formData;
  if (typeof files === "FileList") {
    for (let i = 0; i < files.length; i++) {
      self.formData.append(i, files[i]);
    }
  } else {
    self.formData.append("file", files);
  }
  self.createFormData = function (obj, subKeyStr = "") {
    for (let i in obj) {
      let value = obj[i];
      let subKeyStrTrans = subKeyStr ? subKeyStr + "[" + i + "]" : i;

      if (typeof value === "string" || typeof value === "number") {
        self.formData.append(subKeyStrTrans, value);
      } else if (typeof value === "object") {
        self.createFormData(value, subKeyStrTrans);
      }
    }
  };
  self.createFormData(obj);
  return self.formData;
}

function addFiles(formData, files) {
  // eslint-disable-next-line valid-typeof
  if (typeof files === "FileList") {
    for (let i = 0; i < files.length; i++) {
      formData.formData.append(i, files[i]);
    }
  } else {
    formData.append("file", files);
  }
  return formData;
}

function addData(formData, obj, subKeyStr = "") {
  for (let i in obj) {
    let value = obj[i];
    let subKeyStrTrans = subKeyStr ? subKeyStr + "[" + i + "]" : i;

    if (typeof value === "string" || typeof value === "number") {
      formData.append(subKeyStrTrans, value);
    } else if (typeof value === "object") {
      createFormData(value, subKeyStrTrans);
    }
  }
  return formData;
}

export function newObjAndFiles2FormData(obj, files) {
  let formData = new FormData();
  formData = addFiles(formData, files);
  formData = addData(formData, obj);
  return formData;
}

const debounce = (fn, time = 700) => {
  let timeout;
  return function () {
    const functionCall = () => fn.apply(this, arguments);
    clearTimeout(timeout);
    timeout = setTimeout(functionCall, time);
  };
};

function IsJson(str) {
  try {
    JSON.parse(str);
  } catch (e) {
    return false;
  }
  return true;
}

function replaceNbsps(str) {
  var re = new RegExp("&nbsp;?", "g");
  return str.replace(re, " ");
}

function replaceNs(str) {
  var re = new RegExp("\\n?", "g");
  return str.replace(re, "");
}

function replaceTs(str) {
  var re = new RegExp("\\t?", "g");
  return str.replace(re, "");
}

function replaceSpace(str) {
  var re = new RegExp("s", "g");
  return str.replace(re, "");
}

function replaceBackSpace(str) {
  return str.trim();
}

function formatDate(date = 1, time) {
  let t = new Date();
  let now = t.now();
  let dateArr = now.split("-");
  let formattedDate = dateArr.forEach((s) => {
    if (s === "yyyy") return t.getFullYear;
    if (s === "m") return t.getMonth;
  });
}

function trimStr(str) {
  str = replaceNbsps(str);
  str = replaceNs(str);
  str = replaceTs(str);
  // str = replaceSpace(str)
  str = replaceBackSpace(str);
  return str;
}

function setMorph(data) {
  if (!data.model) return;
  if (!data.id) return;
  if (!data.morph) return;
  let url = getMorphUrl(data.model, data.id);
}

function getMorphUrl(model, id) {
  return `/adminsc/${model}/createOrUpdate/${id}`;
}

function cachePage(className) {
  const html = $(className).first().outerHTML;
  // return html
  return damn_ampersand(trimStr(html));
}

const validate = {
  sort: () => {
    const error = this.nextElementSibling;
    const ar = this.value.match(/\D+/);
    if (ar) {
      error.innerText = "Только цифры";
      error.style.opacity = "1";
    } else {
      if (error.style.opacity === "1") {
        error.style.opacity = "0";
      }
    }
  },
  email: (email) => {
    if (!email) return false;
    const text = "Неправильный формат почты";
    const re =
      /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    const res = re.test(String(email).toLowerCase());
    if (!res) return text;
    return false;
  },
  password: (password) => {
    if (!password) return false;
    let text =
      "Пароль может состоять из - Большие латинские бкувы - Маленькие латинские буквы";
    let res = /^[a-zA-Z0-9-_!#$%^&*()]{6,30}$/.test(password);
    if (!res) return text;
    return false;
  },
};

const popup = {
  show: function (txt) {
    const popup = this.el("div", "popup");

    const close = this.el("div", "popup__close");
    close.innerText = "X";

    const popup__item = this.el("div", "popup__item");
    popup__item.innerText = txt;
    popup__item.append(close);

    popup.append(popup__item);
    popup.addEventListener("click", this.close, true);
    document.body.append(popup);

    const hideDelay = 5000;
    setTimeout(() => {
      popup__item.classList.remove("popup__item");
      popup__item.classList.add("popup-hide");
    }, hideDelay);
    const removeDelay = hideDelay + 950;
    setTimeout(() => {
      popup__item.remove();
    }, removeDelay);
  },

  close: function ({ target }) {
    if (target.classList.contains("popup__close")) {
      this.closest(".popup").remove();
    }
  },
  el: function (tagName, className) {
    const el = document.createElement(tagName);
    el.classList.add(className);
    return el;
  },
};

function getPhpSession() {
  return (
    document.querySelector('meta[name="phpSession"]').getAttribute("content") ??
    null
  );
}

function sanitizeInput(input) {
  if (!input) return;
  const map = {
    "&": "&amp;",
    "<": "&lt;",
    ">": "&gt;",
    // '"': '&quot;',
    "'": "&#39;",
    "(": "&fp",
    ")": "&bp",
    "/": "&fs",
    "\\": "&bs",
    // ".": '&dot',
    ";": "&sc",
    "|": "&or",
    "?php": "&?php",
    delete: "&del",
  };
  const reg = /[&<>'()\/\\;]/gi;
  const sanitized = input.replace(reg, (match) => {
    return map[match];
  });
  return sanitized.trim();
}

function passwordValidator(pass) {
  const min = 6;
  const errors = [];

  const replacePattern = /[a-zA-Z0-9\@\-\_\.А-я]*/;
  if (!pass.length) {
    errors.push("Поле не должно быть пустым");
  }
  if (pass.replace(replacePattern, "").length) {
    errors.push("Разрешены только английские");
  }
  if (pass.length < min) {
    errors.push("Длина меньше 6 символов");
  }
  return errors;
}

function emailValidator(mail) {
  const email = decodeURI(mail); //иначе русские буквы после @ шифруются в url
  // const eng = '[а-яА-Я]*'
  const min = 2;
  // const at = '@'
  const minLengthAfterAt = "(.){2,}@(.){2,}";
  const dot = ".";
  const domainLength = "^(.){2,}@(.){2,}\.(.){2,}$";
  const errors = [];

  const replacePattern = /[a-zA-Z0-9\@\-\_\.]*/;
  if (!email.length) {
    errors.push("Поле не должно быть пустым");
  }
  if (email.replace(replacePattern, "").length) {
    errors.push("Разрешены только английские");
  }
  if (email.length < min) {
    errors.push("Длина меньше 2 символов");
  }
  if (!/[\@]/.test(email)) {
    errors.push("Нет знака @");
  }
  if (!email.match(minLengthAfterAt)) {
    errors.push("Меньше 2 знаков после @");
  }
  if (!email.includes(dot)) {
    errors.push("Нет точки");
  }
  if (!email.match(domainLength)) {
    errors.push("Меньше 2 знаков После точки");
  }
  return errors;
}

function createEl(tagName, className = "", text = "") {
  let div = document.createElement(tagName);
  if (className) {
    div.classList.add(className);
  }
  div.innerText = text ? text : "";
  return div;
}

class createElement {
  constructor() {
    this.attributes = [];
  }

  tag(tag) {
    this.tag = tag;
    return this;
  }

  className(className) {
    this._className = className;
    return this;
  }

  field(field) {
    this._field = field;
    return this;
  }

  text(txt) {
    this._text = txt;
    return this;
  }

  html(html) {
    this._html = html;
    return this;
  }

  attr(key, value) {
    this.attributes.push([key, value]);
    return this;
  }

  get() {
    let el = document.createElement(this.tag);
    if (this._text) {
      el.innerText = this._text;
    }
    if (this._html) {
      el.innerHTML = this._html;
    }
    if (this._className) {
      el.classList.add(this._className);
    }
    if (this._field) {
      el.dataset.field = this._field;
    }
    this.attributes.forEach((entry, i) => {
      el.setAttribute(entry[0], entry[1]);
    });
    return el;
  }
}

const time = {
  m: 60,
  h: 60 * 60,
  d: 60 * 60 * 24,
  mMs: 60 * 1000,
  hMs: 60 * 60 * 1000,
  dMs: 60 * 60 * 24 * 1000,
};

async function post(url, data = {}, headers = {}) {
  const body = setBody(data);
  const header = setHeaders(data, headers);
  const init = { method: "POST", header, body };

  const res = await sendPost(url, init).catch((err) => {
    console.log(err);
  });
  handleResponse(res);
  showMessage(res);
  return res;
}

function setHeaders(body, headers) {
  if (body instanceof FormData) {
    // Заголовок Content-Type НЕ нужно указывать вручную!
    // Браузер сам установит его с правильным boundary
    // headers["Content-Type"] = "application/x-www-form-urlencoded";
    return headers;
  } else if (isPlainObject(body)) {
    headers["Content-Type"] = "application/json";
    headers["X-Requested-With"] = "XMLHttpRequest";
    return headers;
  }
}

function setBody(body) {
  if (body instanceof FormData) {
    body.append("phpSession", getPhpSession());
    return body;
  }
  body.phpSession = getPhpSession();
  return JSON.stringify(body, null, 2);
}

function damn_ampersand(str) {
  return str.replaceAll("&", "%26");
}

function isPlainObject(obj) {
  return (
    typeof obj === "object" &&
    obj !== null &&
    Object.prototype.toString.call(obj) === "[object Object]"
  );
}

function sendPost(url, init) {
  // eslint-disable-next-line no-async-promise-executor
  return new Promise(async (resolve, reject) => {
    const res = await fetch(url, init)
      .then(async (res) => {
        if (res.status === 200) {
          const data = await res.json();
          resolve(data);
        }
      })
      .catch((err) => {
        console.log("Fetch error" + err.message);
        reject(err.message);
      });
  });
}

function showMessage(res) {
  const msg = $(".message")[0];
  if (!msg) return false;
  if (res.msg) {
    msg.innerHTML = res.msg;
  } else if (res.success) {
    msg.innerHTML = res.success;
  } else if (res.error) {
    msg.innerHTML = res.error;
  }
  $(msg).removeClass("success");
  $(msg).removeClass("error");
}

function handleResponse(res) {
  try {
    if (res?.popup) {
      popup.show(res?.popup);
    } else {
      showMessage(res);
    }
    return res;
  } catch (e) {
    console.log(
      "////////////********* REQUEST ERROR ***********//////////////////////",
    );
    if (IsJson(res.response)) {
      console.log(JSON.parse(res.response));
    } else {
      console.log(res.response);
    }
    return false;
  }
}

class ElementCollection extends Array {
  on(event, cbOrSelector, cb) {
    if (typeof cbOrSelector === "function") {
      this.forEach((e) => e.addEventListener(event, cbOrSelector));
    } else {
      let elems = this[0].querySelectorAll(cbOrSelector);
      elems.forEach((elem) => {
        elem.addEventListener(event, cb);
      });
    }
  }

  value = function () {
    return this[0].getAttribute("value");
  };
  first = function () {
    return this[0];
  };
  attr = function (attrName, attrVal) {
    if (attrVal) {
      this[0].setAttribute(attrName, attrVal);
    }
    return this[0].getAttribute(attrName);
  };
  selectedIndexValue = function () {
    if (this.length) return this[0].selectedOptions[0].value;
  };
  options = function () {
    if (this.length) return this[0].options;
  };
  count = function () {
    return this.length;
  };
  text = function () {
    if (this.length) return this[0].innerText;
  };
  checked = function () {
    if (this.length) return this[0].checked;
  };
  getWithStyle = function (attr, val) {
    let arr = [];
    this.forEach((s) => {
      if (s.style[attr] === val) {
        arr.push(s);
      }
    });
    return arr;
  };
  addClass = function (className) {
    this.forEach((s) => {
      s.classList.add(className);
    });
  };
  removeClass = function (className) {
    this.forEach((s) => {
      s.classList.remove(className);
    });
  };
  hasClass = function (className) {
    if (this.classList.contains(className)) return true;
  };
  append = function (el) {
    this[0].appendChild(el);
  };
  find = function (item) {
    if (typeof item === "string") {
      return this[0].querySelector(item);
    } else {
      let filtered = this[0].filter((el) => {
        return el === item;
      });
      return filtered[0];
    }
  };
  findAll = function (item) {
    if (typeof item === "string") {
      return this[0].querySelectorAll(item);
    }
  };

  css = function (attr, val) {
    if (!val) {
      return this[0].style[attr];
    }
    this.forEach((s) => {
      s.style[attr] = val;
    });
  };

  ready(cb) {
    const isReady = this.some((e) => {
      return e.readyState != null && e.readyState != "loading";
    });
    if (isReady) {
      cb();
    } else {
      document.addEventListener("DOMContentLoaded", cb);
    }
  }
}

function $(selector) {
  if (typeof selector === "string" || selector instanceof String) {
    return new ElementCollection(...document.querySelectorAll(selector));
  } else {
    return new ElementCollection(selector);
  }
}

function getCookie(key) {
  let match = document.cookie.match("(^|;)?" + key + "=([^;]*)");
  return match ? match[2] : false;
}

function cookieRemove(key) {
  if (cookieExists(key)) document.cookie = key + "=; Max-Age=-1;";
  return false;
}

function cookieExists(key) {
  let match = document.cookie.match("(^|;)?" + key + "=([^;]*)");
  return !!match;
}

function getCookieExpires(digit, unit) {
  const units = {
    s: 1,
    m: 60,
    h: 60 * 60,
    d: 60 * 60 * 24,
    w: 60 * 60 * 24 * 7,
    M: 60 * 60 * 24 * 30,
    y: 60 * 60 * 24 * 365,
  };

  const date = new Date();
  date.setTime(date.getTime() + digit * units.unit);
  return date;
}

function setCookie(
  key,
  value,
  digit,
  unit,
  path = "/",
  domain = "vitexopt.ru",
  Secure = false,
  HttpOnly = false,
) {
  const expires = getCookieExpires(digit, unit);
  const secure = Secure ? "Secure" : "";
  const httpOnly = HttpOnly ? "HttpOnly" : "";
  document.cookie = `${key}=${value}; expires=${expires} path=${path}; SameSite=lax;${secure};${httpOnly}`;
}

function slider() {
  let slider = $(".slider").first();
  if (!slider) return false;
  slider.onclick = function ({ target }) {
    if (target.classList.contains("slide")) {
      let wrap = slider.querySelector(".wrap");
      if (!wrap.style.height) {
        wrap.style.height = wrap.scrollHeight + "px";
      } else {
        wrap.style.height = "";
      }
    }
  };
}

export function fragmentDate(date, order, y, m, d, glue) {
  let o = new Date(date);

  let monthNames = [
    "January",
    "February",
    "March",
    "April",
    "May",
    "June",
    "July",
    "August",
    "September",
    "October",
    "November",
    "December",
  ];
  let dayNames = [
    "Понедельник",
    "Вторник",
    "Среда",
    "Четверг",
    "Пятница",
    "Суббота",
    "Воскресенье",
  ];

  let yyyy = o.getFullYear();
  let mm = o.getMonth() + 1;
  let dd = o.getDate();
  let M = monthNames[o.getMonth()];
  let D = o.getDay();
  let wd = dayNames[o.getDay()];

  if (dd < 10) dd = "0" + dd;
  if (mm < 10) mm = "0" + mm;
  return { yyyy, mm, dd, M, D, wd };
}

function addTooltip(args) {
  [].forEach.call(args, (el) => {
    el.onmouseenter = function () {
      let tip = document.createElement("div");
      tip.classList.add("tip");
      tip.innerText = args.message;

      el.append(tip);
      let remove = () => tip.remove();
      tip.addEventListener("mousemove", remove.bind(tip), true);
    }.bind(args);

    el.onmouseleave = () => {
      let tip = el.querySelector(".tip");
      tip.remove();
    };
  });
}

export {
  passwordValidator,
  // phoneValidator,
  emailValidator,
  sanitizeInput,
  createElement,
  time,
  scrollToTop,
  cookieRemove,
  setCookie,
  getCookie,
  createEl,
  getPhpSession,
  slider,
  cachePage,
  trimStr,
  addTooltip,
  popup,
  debounce,
  IsJson,
  post,
  validate,
  $,
  formatDate,
};
