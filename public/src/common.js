import {Test} from './Test/model/test'
import './common.scss'

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
        let popup = $('.popup').el[0]
        if (!popup) {
            popup = this.el('div', 'popup')
        }
        popup.append(popup__item)
        popup.addEventListener('click', this.close)
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
        req.onerror = function () {
            reject(Error("Network Error"));
        };
        req.onload = async function () {
            resolve(req.response);
        };
    });
}

function MyJquery(elements) {
    this.el = elements
    this.elType = {}.toString.call(elements)
    this.on = function (ev, f) {
        if (!this.el) return

        if (this.elType === "[object HTMLDivElement]") {
            this.el.addEventListener(ev, f)
        }
        if (this.elType === "[object NodeList]") {
            elements.forEach((s) => s.addEventListener(ev, f))
        }
    }
    this.value = function () {
        return this.el[0].getAttribute('value')
    }

    this.attr = function (attrName, attrVal) {
        if (attrVal) {
            this.el[0].setAttribute(attrName, attrVal)
        }
        return this.el[0].getAttribute(attrName)
    }

    this.selectedIndexValue = function () {
        if (this.el.length)
            return this.el[0].selectedOptions[0].value
    }
    this.options = function () {
        if (this.el.length) return this.el[0].options
    }
    this.count = function () {
        return this.el.length
    }
    this.text = function () {
        if (this.el.length) return this.el[0].innerText
    }
    this.checked = function () {
        if (this.el.length) return this.el[0].checked
    }

    this.getWithStyle = function (attr, val) {
        let arr = []
        elements.forEach((s) => {
            if (s.style[attr] === val) {
                arr.push(s)
            }
        })
        return arr
    }
    this.addClass = function (className) {
        if (this.elType === "[object HTMLDivElement]") {
            this.el.classList.add(className)
        }
        if (["[object NodeList]", "[object Array]"].includes(this.elType)) {
            this.el.forEach((s) => {
                s.classList.add(className)
            })
        }
    }
    this.removeClass = function (className) {
        if (this.elType === "[object HTMLDivElement]") {
            this.el.classList.remove(className)
        }
        if (["[object NodeList]", "[object Array]"].includes(this.elType)) {
            this.el.forEach((s) => {
                s.classList.remove(className)
            })
        }
    }
    this.hasClass = function (className) {
        if (this.el.classList.contains(className)) return true
    }
    this.append = function (el) {
        this.el[0].appendChild(el)
    }
    this.find = function (selector) {
        if (["[object HTMLDivElement]", "[object HTMLInputElement]"].includes(this.elType)) {
            return this.el.querySelector(selector)
        }
        if (["[object NodeList]", "[object Array]"].includes(this.elType)) {
            return this.el[0].querySelector(selector)
        }
    }
    this.css = function (attr, val) {
        if (!val) {
            return this.el[0].style[attr]
        }
        if (this.elType === "[object HTMLDivElement]") {
            this.el.style[attr] = val
        }
        if (this.elType === "[object NodeList]") {
            elements.forEach((s) => {
                s.style[attr] = val
            })
        }
    }
}

function $(selector) {
    let elements = ''
    if (typeof selector === "string") {
        elements = document.querySelectorAll(selector)
    } else {
        elements = selector
    }
    return new MyJquery(elements);
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
            tip.addEventListener('mousemove', remove.bind(tip))
        }.bind(args)

        el.onmouseleave = () => {
            let tip = el.querySelector('.tip')
            tip.remove()
        }
    }, [args])
}

function navigate(str) {
    switch (true) {
        case /\/adminsc\/test/.test(str):
            $('.module.test').addClass('activ')
            break;
        case /\/adminsc\/settings/.test(str):
        case /\/adminsc\/Sitemap/.test(str):
            $('.module.settings').addClass('activ')
            break;
        case /\/adminsc\/crm/.test(str):
            $('.module.crm').addClass('activ')
            break;
        case /\/adminsc\/catalog/.test(str):
            $('.module.catalog').addClass('activ')
            break;
        case /\/adminsc\/test/.test(str):
            $('.module.test').addClass('activ')
            break;
        default:
            $('.module.home').addClass('activ')
            break;
    }
}

class test_delete_button {
    constructor(elem) {
        if (!elem) return
        this._elem = $(elem).el[0];
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

async function fetchWrap(Obj, file) {
    let data = new FormData;
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
            'HTTP_X_REQUESTED_WITH': 'XMLHttpRequest',
        }
    });
    return prom
}

export {navigate, addTooltip, popup, test_delete_button, post, get, uniq, validate, $, fetchWrap, fetchW}
