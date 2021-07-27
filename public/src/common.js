let validate = {
    sort: function () {
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

    email:function (email) {
        if (!email) return false
        let  re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    },

    password:function (password) {
        if (!password) return false
        let re = /^[a-zA-Z\-0-9]{6,20}$/
        return re.test(password)
    }
}



function clearCache() {
    async function clearCache() {
        let response = await fetch('/adminsc/clearCache')
        let result = await response.text();
    }
    clearCache().catch(alert);
}

let popup = {
    show:function (txt) {
        let close = this.el('div', 'popup__close')
        close.innerText = 'X'
        let popup__item = this.el('div', 'popup__item')

        popup__item.innerText = txt
        popup__item.append(close)
        let popup = this.el('div', 'popup')
        popup.append(popup__item)
        popup.addEventListener('click', this.close)
        // document.body.addEventListener('click', this.close)
        document.body.append(popup)
    },
    close:function (e) {
        if (e.target.classList.contains('popup__close')){
            let popup = this.closest('.popup').remove()
        }
    },
    el:function (tagName, className) {
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

async function post(url, data) {
//      debugger;
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
        req.onload = function () {
            resolve(req.response);
        };
    });
}

function MyJquery(elements) {
    this.el = elements
    this.elType = {}.toString.call(elements)
    this.on = function (ev, f) {
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
    this.count = function () {
        return this.el.length
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
        this.el.forEach((s) => {
            s.classList.remove(className)
        })
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
class test_delete {
    constructor(elem) {
        this._elem = elem;
        elem.onclick = this.onClick.bind(this); // (*)
        elem.onmouseenter = this.showToolip
        elem.onmouseleave = this.hideTooltip
        elem.onmousemove = this.changeTooltipPos
    }

    async delete() {
        if (confirm('Удалить тест?')) {
            let id = $('.test-name').value()
            let res = await post('/test/delete',
                {id: id}
            )
            res = JSON.parse(res)
            if (res.msg === 'ok'){
                window.location = '/test/edit'
            }
        }
    }
    changeTooltipPos(e) {
        this.tip.style.top = e.pageY + 35 + 'px'
        this.tip.style.left = e.pageX - 170 + 'px'
    }
    hideTooltip() {
        this.tip.remove()
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
    onClick(event) {
        let action = event.target.closest('.test_delete').dataset['click'];
        if (action) {
            this[action]();
        }
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
        body: 'param='+ JSON.stringify(Obj),
        method: 'post',
        headers:{
            'Content-Type':'application/x-www-form-urlencoded',
            'HTTP_X_REQUESTED_WITH':'XMLHttpRequest',
        }
    });
    return prom
}
export {popup, test_delete, post, get, uniq, validate, $, fetchWrap, fetchW}
