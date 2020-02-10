$(function () {
    $('#autocomplete').autocomplete({

        source: '/search',
        minLength: 1,
        appendTo: $("#autocomplete").parent(),
        select: function (event, ui) {
            window.location = 'http://catalog/search?search=' + encodeURIcomponent(ui.item.value);
        }
    });


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




});
