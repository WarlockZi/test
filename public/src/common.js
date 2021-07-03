let validate = {
    sort: function (s) {
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
        const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if (!re.test(email)) {
            return false
        }
        return true;
    },

    password:function (password) {
        const re = /^[a-zA-Z\-0-9]{6,20}$/;
        if (!re.test(password)) {
            return false
        }
        return true;
    }
}


function get_cookie(cookie_name) {
    var results = document.cookie.match('(^|;)?' + cookie_name + '=([^;]*)');

    if (results)
        $('#cookie-notice').css({bottom: "-100%"});
    // return (unescape(results[2]));
    else
        $('#cookie-notice').css({bottom: "0"});
    setCookie();
    return null;
}
function setCookie() {
    const date = new Date(),
        minute = 60 * 1000,
        day = minute * 60 * 24;

    var days = 1;
    date.setTime(date.getTime() + (days * day));
    $('#cookie-notice').css({bottom: "-100%"});
    document.cookie = "cn=1; expires=" + date + "path=/; SameSite=lax";
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
        let close = document.createElement('div')
        close.classList.add('close')
        let popup = document.createElement('div')
        close.classList.add('popup')
        popup.innerText = txt
        popup.append(close)
        let wrapper = document.createElement('div')
        wrapper.classList.add('popup__wrapper')
        wrapper.append(popup)
        popup.addEventListener('click', this.close)
        document.body.append(wrapper)
    },
    close:function (e) {
        if (e.target.classList.contains('close')){

        }
        
    }
}

const uniq = (array) => Array.from(new Set(array));

async function get(key) {
    var p = window.location.search;
    p = p.match(new RegExp(key + '=([^&=]+)'));
    return p ? p[1] : false;
}

async function post(url, data) {
//      debugger;
    return new Promise(function (resolve, reject) {
        data.token = document.querySelector('meta[name="token"]').getAttribute('content')
        var req = new XMLHttpRequest();
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
        if (this.elType === "[object HTMLDivElement]") {
            return this.el.querySelector(selector)
        }
        if (["[object NodeList]", "[object Array]"].includes(this.elType)) {
            return this.el[0].querySelector(selector)
        }
    }
    this.css = function (attr, val) {
        if (!val) {
            return el.style[attr]
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
    let elements = []
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
            if (res.msg === 'ok'){
                window.location.reload()
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
