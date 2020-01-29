$(function () {
    $('#autocomplete').autocomplete({

        source: '/search',
        minLength: 1,
        appendTo: $("#autocomplete").parent(),
        select: function (event, ui) {
            window.location = 'http://catalog/search?search=' + encodeURIcomponent(ui.item.value);
        }
    });



    // function set_cookie(name, value, exp_y, exp_m, exp_d, path, domain, secure) {
    //     var cookie_string = name + "=" + escape(value);
    //     if (exp_y) {
    //         var expires = new Date(exp_y, exp_m, exp_d);
    //         cookie_string += "; expires=" + expires.toGMTString();
    //     }
    //     if (path)
    //         cookie_string += "; path=" + escape(path);
    //     if (domain)
    //         cookie_string += "; domain=" + escape(domain);
    //     if (secure)
    //         cookie_string += "; secure";
    //     document.cookie = cookie_string;
    // }

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

    function getcookie(a) {
        var b = new RegExp(a + '=([^;]){1,}');
        debugger;
        var c = b.exec(document.cookie);
        if (c) {
            c = c[0].split('=');
        } else return false;
        return c[1] ? c[1] : false;
    }

    var notice = get_cookie("cn");

    debugger;
    if (notice != "1") {
    } else {
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

    function $_GET(key) {
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

});
