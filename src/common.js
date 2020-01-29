const uniq = (array) => Array.from(new Set(array));

async function get(key) {
    var p = window.location.search;
    p = p.match(new RegExp(key + '=([^&=]+)'));
    return p ? p[1] : false;
}


async function post(url, data) {
//      debugger;
    return new Promise(function (resolve, reject) {
        var req = new XMLHttpRequest();
        req.open('POST', url);
        req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        req.setRequestHeader('Content-Type', 'application/json');
        req.setRequestHeader("X-Requested-With", "XMLHttpRequest");
        req.send('param=' + JSON.stringify(data));
        req.onerror = function () {
            reject(Error("Network Error"));
        };
        req.onload = function () {
            resolve(req.response);
        };
    });
}


export {post,get,uniq};
