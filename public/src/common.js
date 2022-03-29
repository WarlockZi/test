import './common.scss'

function dropDown (elementId) {
  var dropdown = document.getElementById(elementId);
  try {
    showDropdown(dropdown);
  } catch (e) {

  }
  return false;
};

function showDropdown(element) {
  var event;
  event = document.createEvent('MouseEvents');
  event.initMouseEvent('mousedown', true, true, window);
  element.dispatchEvent(event);
};


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
    let re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
  },
  password: (password) => {
    if (!password) return false
    let re = /^[a-zA-Z\-0-9]{6,20}$/
    return re.test(password)
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
  return new Promise(function (resolve, reject) {
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
    req.onload = async function () {
      resolve(req.response);
    };
  });
}

class ElementCollection extends Array  {

  // el = this
  // elType = function(){return {}.toString.call(this)}

  on(event, cbOrSelector, cb) {
    if (typeof cbOrSelector === 'function') {
      this.forEach(e => e.addEventListener(event, cbOrSelector))
    }else{
      this.forEach(elem=>{
        elem.addEventListener(event, e =>{
          if (e.target===cbOrSelector) cb(e)
        })})
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
    if (typeof item === 'string'){
      return this[0].querySelector(item)
    }else{
      let filtered =  this[0].filter((el)=>{
        return el === item
      })
      return filtered[0]
    }
  }
  findAll = function (item) {
    if (typeof item === 'string'){
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




function addTooltip(args) {
  let ar = [...args.els]
  ar.map((el) => {
    el.onmouseenter = function () {
      let tip = document.createElement('div')
      $(tip).addClass('tip')
      tip.innerText = args.message
      el.append(tip)
      let remove = () => tip.remove()
      tip.addEventListener('mousemove', remove.bind(tip), true)
    }.bind(args)

    el.onmouseleave = () => {
      let tip = el.querySelector('.tip')
      tip.remove()
    }
  }, [args])
}

class test_delete_button {
  constructor(elem) {
    if (!elem) return
    this._elem = $(elem)[0];
    this._elem.onclick = this.delete
    this._elem.onmouseenter = this.showToolip
    this._elem.onmouseleave = this.hideTooltip
    this._elem.onmousemove = this.changeTooltipPos
  }

  async delete() {
    if (confirm('Удалить тест?')) {
      let res = test.del()
      if (res.msg === 'ok') {
        window.location = '/test/edit'
      }
    }
  }

  showToolip(e) {
    let x = e.clientX
    let y = e.clientY
    let tip = document.createElement('div')
    $(tip).addClass('tip')
    tip.style.top = y + 70 + 'px'
    tip.style.left = x - 170 + 'px'
    tip.innerText = this.getAttribute('tip')
    this.tip = tip
    document.body.append(tip)
  }

  hideTooltip() {
    this.tip.remove()
  }

  changeTooltipPos(e) {
    this.tip.style.top = e.pageY + 35 + 'px'
    this.tip.style.left = e.pageX - 170 + 'px'
  }
}




export {dropDown,
  addTooltip,
  popup,
  test_delete_button,
  post, get, uniq,
  validate, $}
