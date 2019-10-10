$(function () {
   $('#autocomplete').autocomplete({

      source: '/search',
      minLength: 1,
      appendTo: $("#autocomplete").parent(),
      select: function (event, ui) {
         window.location = 'http://catalog/search?search=' + encodeURIcomponent(ui.item.value);
      }
   });


   if ($.cookie("cn")) {
      $('#cookie-notice').css({bottom: "-100%"});
   }
   else {
      $('#cookie-notice').css({bottom: "0"});
   }




});

function setCookie() {
   //          debugger;
   $('#cookie-notice').css({bottom: "-100%"});
   var days = 1,
   months = 1,
   date = new Date(),
   minute = 60 * 1000,
   day = minute * 60 * 24;
   date.setTime(date.getTime() + (days * day));
   $.cookie("cn", "1", {
      expires: date,
      path: "/",
      SameSite: 'lax'
   });
}
;

const uniq = (array) => Array.from(new Set(array));

function $_GET(key) {
   var p = window.location.search;
   p = p.match(new RegExp(key + '=([^&=]+)'));
   return p ? p[1] : false;
}


function post(url, data) {
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