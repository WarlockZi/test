// function autocomplete() {
//     $('#autocomplete').autocomplete({
//         source: '/search',
//         minLength: 1,
//         appendTo: $("#autocomplete").parent(),
//         select: function (event, ui) {
//             window.location = 'http://catalog/search?search=' + encodeURIcomponent(ui.item.value);
//         }
//     });
// };


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
};


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


export {post, get, uniq}; //, autocomplete};
