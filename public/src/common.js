import './Admin/admin.scss'
import './common.scss'

const debounce = (fn, time = 700) => {
  let timeout;
  return function () {
    const functionCall = () => fn.apply(this, arguments);
    clearTimeout(timeout);
    timeout = setTimeout(functionCall, time);
  }
}

function IsJson(str) {
  try {
    JSON.parse(str);
  } catch (e) {
    return false;
  }
  return true;
}


function replaceNbsps(str) {
  var re = new RegExp('&nbsp;?', "g");
  return str.replace(re, " ");
}

function replaceNs(str) {
  var re = new RegExp('\\n?', "g");
  return str.replace(re, "");
}

function replaceTs(str) {
  var re = new RegExp('\\t?', "g");
  return str.replace(re, "");
}

function replaceSpace(str) {
  var re = new RegExp('\s', "g");
  return str.replace(re, "");
}
function replaceBackSpace(str) {
  return str.trim();
}


function trimStr(str) {
  str = replaceNbsps(str)
  str = replaceNs(str)
  str = replaceTs(str)
  str = replaceSpace(str)
  str = replaceBackSpace(str)
  return str
}

function cachePage(className) {
  let html = $(className)[0].outerHTML
  return trimStr(html)
}
let validate = {
  sort: () => {
    let error = this.nextElementSibling
    let ar = this.value.match(/\D+/)
    if (ar) {
      error.innerText = 'Только цифры'
      error.style.opacity = '1'
    } else {
      if (error.style.opacity === "1") {
        error.style.opacity = '0'
      }
    }
  },
  email: (email) => {
    if (!email) return false
    let text = "Неправильный формат почты"
    let re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    let res = re.test(String(email).toLowerCase())
    if (!res) return text
    return false
  },
  password: (password) => {
    if (!password) return false
    let text = "Пароль может состоять из \n " +
      "- Большие латинские бкувы \n" +
      "- Маленькие латинские буквы \n" +
      "- Цифры \n" +
      "- Должен содержать не менее 6 символов"
    let res = /^[a-zA-Z\-0-9]{6,20}$/.test(password)
    if (!res) return text
    return false
  }
}


// function up() {
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
    let close = this.el('div', 'popup__close')
    close.innerText = 'X'
    let popup__item = this.el('div', 'popup__item')

    popup__item.innerText = txt
    popup__item.append(close)
    let popup = $('.popup')[0]
    if (!popup) {
      popup = this.el('div', 'popup')
    }
    popup.append(popup__item)
    popup.addEventListener('click', this.close, true)
    document.body.append(popup)
    let hideDelay = 5000;
    setTimeout(() => {
      popup__item.classList.remove('popup__item')
      popup__item.classList.add('popup-hide')
    }, hideDelay)
    let removeDelay = hideDelay + 950;
    setTimeout(() => {
      popup__item.remove()
      if (callback) {
        callback()
      }
    }, removeDelay)
  },

  close: function (e) {
    if (e.target.classList.contains('popup__close')) {
      let popup = this.closest('.popup').remove()
    }
  },
  el: function (tagName, className) {
    let el = document.createElement(tagName)
    el.classList.add(className)
    return el
  }
}

const uniq = (array) => Array.from(new Set(array));


async function get(key) {
  let p = window.location.search;
  p = p.match(new RegExp(key + '=([^&=]+)'));
  return p ? p[1] : false;
}

async function post(url, data = {}) {

  return new Promise(async function (resolve, reject) {
      data.token = document.querySelector('meta[name="token"]').getAttribute('content')
      let req = new XMLHttpRequest();
      req.open('POST', url, true);
      req.setRequestHeader("X-Requested-With", "XMLHttpRequest");
      if (data instanceof FormData) {
        req.send(data);
      } else {
        req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        req.send('param=' + JSON.stringify(data));
      }
      req.onerror = function (e) {
        reject(Error("Network Error" + e));
      };
      req.onload = function () {
        let res = JSON.parse(req.response)
        let msg = $('.message')[0]

        if (res.popup||res?.arr?.popup) {


          popup.show(res.popup??res?.arr?.popup)
        } else if (res.msg) {
          if (msg) {
            msg.innerHTML = res.msg
            msg.innerHTML = res.msg
            $(msg).removeClass('success')
            $(msg).removeClass('error')
          }
        } else if (res.success) {
          if (msg) {
            msg.innerHTML = res.success
            $(msg).addClass('success')
            $(msg).removeClass('error')
          }

        } else if (res.error) {
          if (msg) {
            msg.innerHTML = ''
            msg.innerHTML = res.error
            $(msg).removeClass('success')
            $(msg).addClass('error')
          }
        }
        resolve(res);
      }
    }
  )

}

class ElementCollection extends Array {

  // el = this
  // elType = function(){return {}.toString.call(this)}

  on(event, cbOrSelector, cb) {
    if (typeof cbOrSelector === 'function') {
      this.forEach(e => e.addEventListener(event, cbOrSelector))
    } else {
      this.forEach(elem => {
        elem.addEventListener(event, e => {
          if (e.target === cbOrSelector) cb(e)
        })
      })
    }
  }

  value = function () {
    return this[0].getAttribute('value')
  }
  attr = function (attrName, attrVal) {
    if (attrVal) {
      this[0].setAttribute(attrName, attrVal)
    }
    return this[0].getAttribute(attrName)
  }
  selectedIndexValue = function () {
    if (this.length)
      return this[0].selectedOptions[0].value
  }
  options = function () {
    if (this.length) return this[0].options
  }
  count = function () {
    return this.length
  }
  text = function () {
    if (this.length) return this[0].innerText
  }
  checked = function () {
    if (this.length) return this[0].checked
  }
  getWithStyle = function (attr, val) {
    let arr = []
    this.forEach((s) => {
      if (s.style[attr] === val) {
        arr.push(s)
      }
    })
    return arr
  }
  addClass = function (className) {
    this.forEach((s) => {
      s.classList.add(className)
    })
  }
  removeClass = function (className) {
    this.forEach((s) => {
      s.classList.remove(className)
    })
  }
  hasClass = function (className) {
    if (this.classList.contains(className)) return true
  }
  append = function (el) {
    this[0].appendChild(el)
  }
  find = function (item) {
    if (typeof item === 'string') {
      return this[0].querySelector(item)
    } else {
      let filtered = this[0].filter((el) => {
        return el === item
      })
      return filtered[0]
    }
  }
  findAll = function (item) {
    if (typeof item === 'string') {
      return this[0].querySelectorAll(item)
    }
  }


  css = function (attr, val) {
    if (!val) {
      return this[0].style[attr]
    }
    this.forEach((s) => {
      s.style[attr] = val
    })
  }
  ready(cb) {
    const isReady = this.some(e => {
      return e.readyState != null && e.readyState != 'loading'
    })
    if (isReady) {
      cb()
    } else {
      document.addEventListener('DOMContentLoaded', cb)
    }
  }

}


function $(selector) {
  if (typeof selector === 'string' || selector instanceof String) {
    return new ElementCollection(...document.querySelectorAll(selector))
  } else {
    return new ElementCollection(selector)
  }
}
export function fragmentDate(date, order, y, m, d, glue) {
  let o = new Date(date)

  let monthNames = ["January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"
  ];
  let dayNames = ["Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота", "Воскресенье"];

  let yyyy = o.getFullYear()
  let mm = o.getMonth()+1
  let dd = o.getDate()
  let M = monthNames[o.getMonth()]
  let D = o.getDay()
  let wd = dayNames[o.getDay()]

  if (dd < 10) dd = '0' + dd;
  if (mm < 10) mm = '0' + mm;
  return {yyyy,mm,dd,M,D,wd}
}


function addTooltip(args) {

  [].forEach.call(args, (el) => {
    el.onmouseenter = function () {
      let tip = document.createElement('div')
      tip.classList.add('tip')
      tip.innerText = args.message

      el.append(tip)
      let remove = () => tip.remove()
      tip.addEventListener('mousemove', remove.bind(tip), true)
    }.bind(args)

    el.onmouseleave = () => {
      let tip = el.querySelector('.tip')
      tip.remove()
    }
  })
}


export {
  cachePage,
  trimStr,
  addTooltip,
  popup,
  debounce,
  IsJson,
  post, get, uniq,
  validate, $
}
