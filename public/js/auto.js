

$(function(){
   $('#autocomplete').autocomplete({

      source: '/search',
      minLength: 1,
      appendTo: $("#autocomplete").parent(),
      select: function (event, ui) {
         window.location = 'http://catalog/search?search=' + encodeURIcomponent(ui.item.value);
      }
   });
   
   function setCookie() {
      //          debugger;
      $('#cookie-notice').css({bottom: "-100%"});
      var days = 1;
      var months = 1;
      var date = new Date();
      var minute = 60 * 1000;
      var day = minute * 60 * 24;
      var week = day * 7;
      var month = minute * 60 * 24 * 30;
      date.setTime(date.getTime() + (days * day));
      $.cookie("cn", "1", {
         expires: date,
         path: "/",
         SameSite: 'lax'
      });
   }
   ;


   if ($.cookie("cn")) {
      $('#cookie-notice').css({bottom: "-100%"});
   }
   else {
      $('#cookie-notice').css({bottom: "0"});
   }
   });
